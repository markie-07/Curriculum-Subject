{{-- View All Equivalencies Modal (Global - Available on all pages) --}}
<div id="viewAllModal" class="fixed inset-0 z-[110] pointer-events-none transition-opacity duration-300 ease-out hidden">
    <div id="viewAllModalPanel" class="absolute top-16 right-4 bg-white w-full max-w-md rounded-lg shadow-2xl transform scale-95 opacity-0 transition-all duration-300 ease-out flex flex-col pointer-events-auto" style="max-height: 70vh; cursor: move; border: 1px solid #e5e7eb;">
        {{-- Draggable Header --}}
        <div id="modalHeader" class="flex justify-between items-center p-3 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-lg cursor-move">
            <div class="flex items-center gap-2">
                <div class="bg-blue-500 p-1.5 rounded">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </div>
                <h2 class="text-sm font-bold text-gray-800">All Equivalencies</h2>
            </div>
            <svg id="expandCollapseIcon" class="w-4 h-4 text-gray-600 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </div>

        {{-- Collapsible Content --}}
        <div id="modalCollapsibleContent">
            {{-- Search Bar --}}
            <div class="p-3 border-b border-gray-200 bg-gray-50">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" id="modalSearchInput" placeholder="Search..." class="w-full text-sm bg-white border border-gray-300 rounded py-1.5 pl-8 pr-3 focus:outline-none focus:ring-1 focus:ring-blue-500 transition">
                </div>
            </div>

            {{-- Equivalencies List --}}
            <div id="modalEquivalenciesList" class="flex-1 overflow-y-auto p-3 space-y-2">
                {{-- Will be populated by JavaScript --}}
            </div>

            {{-- Footer --}}
            <div class="p-3 border-t border-gray-200 bg-gray-50 rounded-b-lg flex justify-between items-center">
                <p class="text-xs text-gray-500">
                    Total: <span id="totalEquivalenciesCount" class="font-semibold text-gray-700">0</span>
                </p>
                <button id="closeViewAllModalBtn" class="px-3 py-1 text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded transition-all">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// View All Equivalencies Modal - Global Script
document.addEventListener('DOMContentLoaded', function() {
    const viewAllBtn = document.getElementById('viewAllEquivalenciesBtn');
    const viewAllModal = document.getElementById('viewAllModal');
    const viewAllModalPanel = document.getElementById('viewAllModalPanel');
    const closeViewAllModalBtn = document.getElementById('closeViewAllModalBtn');
    const modalEquivalenciesList = document.getElementById('modalEquivalenciesList');
    const modalSearchInput = document.getElementById('modalSearchInput');
    const totalEquivalenciesCount = document.getElementById('totalEquivalenciesCount');
    const modalHeader = document.getElementById('modalHeader');
    const modalCollapsibleContent = document.getElementById('modalCollapsibleContent');
    const expandCollapseIcon = document.getElementById('expandCollapseIcon');

    if (!viewAllBtn) return; // Exit if button doesn't exist

    let isExpanded = true;
    let isDragging = false;
    let currentX, currentY, initialX, initialY;
    let xOffset = 0, yOffset = 0;
    let hasDragged = false;

    // Show modal
    const showViewAllModal = () => {
        populateModalEquivalencies();
        xOffset = 0;
        yOffset = 0;
        viewAllModalPanel.style.transform = `translate(0px, 0px)`;
        viewAllModal.classList.remove('hidden');
        setTimeout(() => {
            viewAllModal.classList.remove('opacity-0');
            viewAllModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    // Hide modal
    const hideViewAllModal = () => {
        viewAllModal.classList.add('opacity-0');
        viewAllModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => viewAllModal.classList.add('hidden'), 300);
        modalSearchInput.value = '';
    };

    // Populate equivalencies
    const populateModalEquivalencies = async () => {
        modalEquivalenciesList.innerHTML = '<div class="text-center text-gray-500 py-10 text-sm">Loading...</div>';
        
        try {
            // Fetch all equivalencies from the database
            const response = await fetch('/api/equivalencies', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error('Failed to fetch equivalencies');
            }

            const data = await response.json();
            const equivalencies = data.equivalencies || data || [];
            
            modalEquivalenciesList.innerHTML = '';

            if (equivalencies.length === 0) {
                modalEquivalenciesList.innerHTML = '<div class="text-center text-gray-500 py-10 text-sm">No equivalencies found.</div>';
                totalEquivalenciesCount.textContent = '0';
                return;
            }

            equivalencies.forEach(item => {
                const sourceName = item.source_subject_name;
                const equivalentSubject = item.equivalent_subject;
                const equivalentText = equivalentSubject 
                    ? `${equivalentSubject.subject_code} - ${equivalentSubject.subject_name}` 
                    : 'N/A';

                const compactCard = document.createElement('div');
                compactCard.className = 'modal-equivalency-item p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition-all';
                compactCard.innerHTML = `
                    <div class="flex items-center justify-center gap-2">
                        <span class="font-semibold text-gray-800 text-center">${sourceName}</span>
                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                        <span class="font-semibold text-gray-800 text-center">${equivalentText}</span>
                    </div>
                `;
                modalEquivalenciesList.appendChild(compactCard);
            });

            totalEquivalenciesCount.textContent = equivalencies.length;
        } catch (error) {
            console.error('Error fetching equivalencies:', error);
            modalEquivalenciesList.innerHTML = '<div class="text-center text-red-500 py-10 text-sm">Error loading equivalencies.</div>';
            totalEquivalenciesCount.textContent = '0';
        }
    };

    // Drag functions
    const dragStart = (e) => {
        if (e.target === modalHeader || modalHeader.contains(e.target)) {
            initialX = e.clientX - xOffset;
            initialY = e.clientY - yOffset;
            isDragging = true;
        }
    };

    const drag = (e) => {
        if (isDragging) {
            e.preventDefault();
            currentX = e.clientX - initialX;
            currentY = e.clientY - initialY;
            xOffset = currentX;
            yOffset = currentY;
            viewAllModalPanel.style.transform = `translate(${currentX}px, ${currentY}px)`;
        }
    };

    const dragEnd = () => {
        initialX = currentX;
        initialY = currentY;
        isDragging = false;
    };

    // Toggle expand/collapse
    const toggleExpandCollapse = () => {
        isExpanded = !isExpanded;
        if (isExpanded) {
            modalCollapsibleContent.style.display = 'block';
            expandCollapseIcon.style.transform = 'rotate(0deg)';
        } else {
            modalCollapsibleContent.style.display = 'none';
            expandCollapseIcon.style.transform = 'rotate(180deg)';
        }
    };

    // Event listeners
    viewAllBtn.addEventListener('click', () => {
        // Toggle modal - if hidden, show it; if visible, hide it
        if (viewAllModal.classList.contains('hidden')) {
            showViewAllModal();
        } else {
            hideViewAllModal();
        }
    });
    closeViewAllModalBtn.addEventListener('click', hideViewAllModal);

    modalHeader.addEventListener('mousedown', (e) => {
        hasDragged = false;
        dragStart(e);
    });

    document.addEventListener('mousemove', (e) => {
        if (isDragging) {
            hasDragged = true;
            drag(e);
        }
    });

    document.addEventListener('mouseup', () => {
        dragEnd();
    });

    modalHeader.addEventListener('click', (e) => {
        if (!hasDragged) {
            toggleExpandCollapse();
        }
    });

    // Search functionality
    modalSearchInput.addEventListener('input', function() {
        const searchTerm = modalSearchInput.value.toLowerCase();
        const items = modalEquivalenciesList.querySelectorAll('.modal-equivalency-item');
        let visibleCount = 0;

        items.forEach(item => {
            const textContent = item.textContent.toLowerCase();
            if (textContent.includes(searchTerm)) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        totalEquivalenciesCount.textContent = visibleCount;
    });
});
</script>
