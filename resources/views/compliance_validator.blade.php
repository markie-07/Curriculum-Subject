@extends('layouts.app')

 @section('content')
 <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <div>
        {{-- Main Content Section --}}
        <div class="bg-white p-10 md:p-12 rounded-2xl shadow-lg border border-gray-200">

            {{-- Page Title Section --}}
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Compliance Validator</h1>
                <p class="text-lg text-gray-600 mt-1">Select an agency to view and access official memorandum orders.</p>
            </div>

            {{-- Main Interactive Area --}}
            <div class="border border-gray-200 rounded-2xl p-8">
                <div class="relative inline-block text-left w-full max-w-9xl">
                    <div>
                        <button type="button" id="agency-button" class="inline-flex justify-center items-center w-full max-w-full rounded-lg border border-gray-300 shadow-sm px-5 py-3 bg-white text-base font-medium text-gray-800 hover:bg-gray-50 hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200" aria-haspopup="true" aria-expanded="true">
                            <span id="selected-agency" class="font-semibold text-center text-gray-700">Select Agency</span>
                        </button>
                    </div>

                    <div id="agency-menu" class="origin-top-right absolute left-0 mt-2 w-full rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-10" role="menu" aria-orientation="vertical" aria-labelledby="agency-button">
                        <div class="py-1" role="none">
                            <button type="button" class="agency-option text-gray-700 block w-full text-left px-4 py-3 text-base hover:bg-blue-100 hover:text-blue-800" role="menuitem" data-agency="CHED" data-target="ched-links">CHED</button>
                            <button type="button" class="agency-option text-gray-700 block w-full text-left px-4 py-3 text-base hover:bg-blue-100 hover:text-blue-800" role="menuitem" data-agency="DepEd" data-target="deped-links">DepEd</button>
                        </div>
                    </div>
                </div>

                <div id="links-container" class="hidden mt-8">
                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-8">
                        <h3 id="links-header" class="text-lg font-semibold text-gray-800 mb-6 border-b border-gray-200 pb-4"></h3>

                        {{-- NEW: Search Bar --}}
                        <div class="mb-6">
                            <input type="text" id="search-bar" placeholder="Search for issuances..." class="w-full max-w-lg px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- CHED Links Section --}}
                        <div id="ched-links" class="hidden space-y-3">
                            @for ($year = 2025; $year >= 1994; $year--)
                                <div class="ched-accordion border border-gray-200 rounded-lg">
                                    <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                        <span class="font-semibold text-gray-700">{{ $year }} CHED Memorandum Orders</span>
                                        <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-2">
                                        <!-- Add Link Button -->
                                        <div class="mb-3 flex justify-end">
                                            <button type="button" class="add-link-btn px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" data-year="{{ $year }}" data-agency="CHED">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Add Link
                                            </button>
                                        </div>
                                        
                                        <!-- Custom Links Container -->
                                        <div class="custom-links-container space-y-2" data-year="{{ $year }}" data-agency="CHED"></div>
                                        
                                        <!-- Fallback Link -->
                                        <a href="https://ched.gov.ph/{{ $year }}-ched-memorandum-orders/" target="_blank" class="block text-blue-600 hover:underline p-2 rounded-md hover:bg-blue-50">View all {{ $year }} issuances on the CHED website</a>
                                    </div>
                                </div>
                            @endfor
                        </div>


                        {{-- DepEd Links Section --}}
                        <div id="deped-links" class="hidden space-y-3">
                            {{-- Accordion for Shape Paper --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Shape Paper</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white">
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/The-Strengthened-Senior-High-School-Program-Shaping-Paper.pdf" target="_blank" class="block text-blue-600 hover:underline">The Strengthened Senior High School Program Shaping Paper</a>
                                </div>
                            </div>

                            {{-- Accordion for Curriculum Guides (Core) --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Curriculum Guides (Core)</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-2">
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Effective-Communication.pdf" target="_blank" class="block text-blue-600 hover:underline">Effective Communication</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Mathematics.pdf" target="_blank" class="block text-blue-600 hover:underline">General Mathematics</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/General-Science.pdf" target="_blank" class="block text-blue-600 hover:underline">General Science</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Life-and-Career-Skills.pdf" target="_blank" class="block text-blue-600 hover:underline">Life and Career Skills</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Mabisang-Komunikasyon.pdf" target="_blank" class="block text-blue-600 hover:underline">Mabisang Komunikasyon</a>
                                    <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Pag-aaral-ng-Kasaysayan-at-Lipunang-Pilipino.pdf" target="_blank" class="block text-blue-600 hover:underline">Pag-aaral ng Kasaysayan at Lipunang Pilipino</a>
                                </div>
                            </div>

                            {{-- Accordion for Curriculum Guides (Academic) --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Curriculum Guides (Academic)</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-4">
                                    <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">ARTS, SOCIAL SCIENCE, AND HUMANITIES</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Arts-1-Creative-Industries-Visual-Art-Literary-Art-Media-Art-Applied-Art-and-Traditional-Art.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Arts 1 (Creative Industries - Visual Art, Literary Art, Media Art, Applied Art, and Traditional Art)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Arts-2-Creative-Industries-II-%E2%80%93-Performing-Arts.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Arts 2 (Creative Industries II – Performing Arts)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Social-Science-1-Introduction-to-Social-Sciences.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Social Science 1 (Introduction to Social Sciences)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Humanities-1-Creative-Writing.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Humanities 1 (Creative Writing)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Humanities-2-Introduction-to-World-Religions-and-Belief-Systems.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Humanities 2 (Introduction to World Religions and Belief Systems)</a>
                                    </div>
                                    <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">ENGINEERING AND TECHNOLOGY</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Engineering-1-Calculus.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Engineering 1 (Calculus)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Engineering-2-Fundamentals-of-Programming.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Engineering 2 (Fundamentals of Programming)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Engineering-3-Basic-Electricity-and-Electronics.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Engineering 3 (Basic Electricity and Electronics)</a>
                                    </div>
                                     <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">BUSINESS, ECONOMICS, AND MANAGEMENT</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Business-1-Business-Enterprise-Simulation.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Business 1 (Business Enterprise Simulation)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Economics-1-Introduction-to-Economics.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Economics 1 (Introduction to Economics)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Management-1-Fundamentals-of-Accountancy-Business-and-Management.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Management 1 (Fundamentals of Accountancy, Business, and Management)</a>
                                    </div>
                                     <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">HEALTH AND MEDICAL SCIENCES</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Health-Science-1-Introduction-to-Health-Science.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Health Science 1 (Introduction to Health Science)</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/Health-Science-2-Basic-Human-Anatomy-and-Physiology.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Health Science 2 (Basic Human Anatomy and Physiology)</a>
                                    </div>
                                </div>
                            </div>

                             {{-- Accordion for Curriculum Guides (TechPro) --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Curriculum Guides (TechPro)</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-4">
                                     <div class="space-y-2">
                                        <h4 class="font-bold text-gray-600">INFORMATION AND COMMUNICATIONS TECHNOLOGY</h4>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Digital-Tools-and-Productivity-Applications.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Digital Tools and Productivity Applications</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Multimedia-Development-and-Design.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Multimedia Development and Design</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Systems-and-Network-Administration.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Computer Systems and Network Administration</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Web-Development.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Web Development</a>
                                        <a href="https://www.deped.gov.ph/wp-content/uploads/2024/05/Computer-Programming.pdf" target="_blank" class="block pl-4 text-blue-600 hover:underline">Computer Programming</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </main>

 <script>
 document.addEventListener('DOMContentLoaded', () => {
    // --- Configuration ---
    const API_BASE_URL = '/api/compliance-links';

    // --- Element Definitions ---
    const agencyButton = document.getElementById('agency-button');
    const agencyMenu = document.getElementById('agency-menu');
    const linksContainer = document.getElementById('links-container');
    const selectedAgencySpan = document.getElementById('selected-agency');
    const linksHeader = document.getElementById('links-header');
    const searchBar = document.getElementById('search-bar');
    
    // Modal elements
    const externalLinkModal = document.getElementById('externalLinkModal');
    const externalLinkModalPanel = document.getElementById('external-link-modal-panel');
    const closeExternalLinkModalButton = document.getElementById('closeExternalLinkModalButton');
    const cancelExternalLinkButton = document.getElementById('cancelExternalLinkButton');
    const confirmExternalLinkButton = document.getElementById('confirmExternalLinkButton');
    const documentTitle = document.getElementById('document-title');
    
    // Add Link Modal elements
    const addLinkModal = document.getElementById('addLinkModal');
    const addLinkModalPanel = document.getElementById('add-link-modal-panel');
    const addLinkModalTitle = document.getElementById('addLinkModalTitle');
    const closeAddLinkModalButton = document.getElementById('closeAddLinkModalButton');
    const cancelAddLinkButton = document.getElementById('cancelAddLinkButton');
    const addLinkForm = document.getElementById('addLinkForm');
    const linkTitleInput = document.getElementById('linkTitle');
    const linkUrlInput = document.getElementById('linkUrl');

    let currentLink = null;
    let currentYear = null;
    let currentAgency = null;
    let editingLinkId = null;
    let isLoadingAll = false;

    // --- Data Management ---
    const fetchAllLinksForAgency = async (agency) => {
        try {
            const response = await fetch(`${API_BASE_URL}?agency=${agency}`);
            const data = await response.json();
            return Array.isArray(data) ? data : [];
        } catch (error) {
            console.error(`Error fetching links for ${agency}:`, error);
            return [];
        }
    };

    const distributeLinks = (links, agency) => {
        // Clear all containers for this agency first
        document.querySelectorAll(`.custom-links-container[data-agency="${agency}"]`).forEach(c => {
            c.innerHTML = '';
            c.dataset.loaded = 'true';
        });

        if (!links || links.length === 0) return;

        // Group links by year
        const grouped = links.reduce((acc, link) => {
            if (!acc[link.year]) acc[link.year] = [];
            acc[link.year].push(link);
            return acc;
        }, {});

        // Render each group
        Object.keys(grouped).forEach(year => {
            renderLinkList(year, agency, grouped[year]);
        });
    };

    const renderLinkList = (year, agency, links) => {
        const container = document.querySelector(`.custom-links-container[data-year="${year}"][data-agency="${agency}"]`);
        if (!container) return;

        container.innerHTML = '';
        links.forEach(link => {
            const linkDiv = document.createElement('div');
            linkDiv.className = 'custom-link-item flex items-center gap-2 p-2 rounded-md hover:bg-blue-50 transition-colors duration-200';
            linkDiv.innerHTML = `
                <a href="${link.url}" target="_blank" class="flex-grow text-blue-600 hover:underline text-sm md:text-base">${link.title}</a>
                <div class="flex gap-1">
                    <button type="button" class="edit-custom-link-btn p-1 text-blue-600 hover:bg-blue-100 rounded transition" data-link-id="${link.id}" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </button>
                    <button type="button" class="delete-custom-link-btn p-1 text-red-600 hover:bg-red-100 rounded transition" data-link-id="${link.id}" title="Delete">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            `;
            
            // Re-bind events for edit/delete
            linkDiv.querySelector('.edit-custom-link-btn').onmouseenter = () => {}; // dummy to ensure ready
            linkDiv.querySelector('.edit-custom-link-btn').onclick = (e) => {
                e.stopPropagation();
                showAddLinkModal(year, agency, link);
            };
            linkDiv.querySelector('.delete-custom-link-btn').onclick = (e) => {
                e.stopPropagation();
                if (confirm('Are you sure you want to delete this custom link?')) {
                    deleteCustomLink(year, agency, link.id);
                }
            };

            container.appendChild(linkDiv);
        });
        container.dataset.loaded = 'true';
    };

    const deleteCustomLink = async (year, agency, linkId) => {
        try {
            const response = await fetch(`${API_BASE_URL}/${linkId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
            if (response.ok) {
                // Refresh all for this agency to keep sync easy
                const links = await fetchAllLinksForAgency(agency);
                distributeLinks(links, agency);
            }
        } catch (error) {
            console.error('Error deleting link:', error);
        }
    };

    // --- Modal Logic ---
    const showExternalLinkModal = (link, title) => {
        currentLink = link;
        documentTitle.textContent = title || 'Official Document';
        externalLinkModal.classList.remove('hidden');
        setTimeout(() => {
            externalLinkModal.classList.remove('opacity-0');
            externalLinkModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hideExternalLinkModal = () => {
        externalLinkModal.classList.add('opacity-0');
        externalLinkModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => externalLinkModal.classList.add('hidden'), 300);
    };

    const showAddLinkModal = (year, agency, existingLink = null) => {
        currentYear = year;
        currentAgency = agency;
        
        if (existingLink) {
            editingLinkId = existingLink.id;
            addLinkModalTitle.textContent = 'Edit Custom Link';
            linkTitleInput.value = existingLink.title;
            linkUrlInput.value = existingLink.url;
        } else {
            editingLinkId = null;
            addLinkModalTitle.textContent = 'Add Custom Link';
            linkTitleInput.value = '';
            linkUrlInput.value = '';
        }

        addLinkModal.classList.remove('hidden');
        setTimeout(() => {
            addLinkModal.classList.remove('opacity-0');
            addLinkModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hideAddLinkModal = () => {
        addLinkModal.classList.add('opacity-0');
        addLinkModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            addLinkModal.classList.add('hidden');
            addLinkForm.reset();
        }, 300);
    };

    // --- Event Listeners ---
    
    // Agency Selection
    document.querySelectorAll('.agency-option').forEach(button => {
        button.addEventListener('click', async () => {
            const agency = button.dataset.agency;
            const targetId = button.dataset.target;
            
            selectedAgencySpan.textContent = agency;
            linksHeader.textContent = `Available ${agency} Issuances`;
            agencyMenu.classList.add('hidden');
            agencyButton.setAttribute('aria-expanded', 'false');
            linksContainer.classList.remove('hidden');
            
            linksContainer.querySelectorAll('div[id$="-links"]').forEach(div => div.classList.add('hidden'));
            const targetSection = document.getElementById(targetId);
            if (targetSection) targetSection.classList.remove('hidden');

            // Load data if needed
            const containers = targetSection.querySelectorAll('.custom-links-container');
            if (containers.length > 0 && !containers[0].dataset.loaded) {
                const links = await fetchAllLinksForAgency(agency);
                distributeLinks(links, agency);
            }

            searchBar.value = '';
            searchBar.dispatchEvent(new Event('input', { bubbles: true }));
        });
    });

    // Accordion Logic
    document.querySelectorAll('.accordion-header').forEach(button => {
        button.addEventListener('click', () => {
            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');
            const isOpening = content.classList.contains('hidden');
            
            content.classList.toggle('hidden', !isOpening);
            icon.classList.toggle('rotate-180', isOpening);
        });
    });

    // Search Functionality
    searchBar.addEventListener('input', () => {
        const searchTerm = searchBar.value.toLowerCase();
        const activeLinksSection = linksContainer.querySelector('#ched-links:not(.hidden), #deped-links:not(.hidden)');
        if (!activeLinksSection) return;

        activeLinksSection.querySelectorAll('.ched-accordion, .deped-accordion').forEach(accordion => {
            let hasVisibleContent = false;
            const links = accordion.querySelectorAll('.accordion-content a');
            
            links.forEach(link => {
                const linkText = link.textContent.toLowerCase();
                const itemDiv = link.closest('.custom-link-item');
                
                if (linkText.includes(searchTerm)) {
                    if (itemDiv) itemDiv.style.display = 'flex';
                    else link.style.display = 'block';
                    hasVisibleContent = true;
                } else {
                    if (itemDiv) itemDiv.style.display = 'none';
                    else link.style.display = 'none';
                }
            });

            // DepEd Subgroups
            accordion.querySelectorAll('.accordion-content > div[class*="space-y"]').forEach(group => {
                const visibleLinks = group.querySelectorAll('a:not([style*="display: none"])');
                group.style.display = visibleLinks.length > 0 ? 'block' : 'none';
                if (visibleLinks.length > 0) hasVisibleContent = true;
            });

            accordion.style.display = (searchTerm === "" || hasVisibleContent) ? 'block' : 'none';
        });
    });

    // Toggle dropdown menu
    agencyButton.addEventListener('click', () => {
        const isHidden = agencyMenu.classList.contains('hidden');
        agencyMenu.classList.toggle('hidden', !isHidden);
        agencyButton.setAttribute('aria-expanded', isHidden);
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', (e) => {
        if (!agencyButton.contains(e.target) && !agencyMenu.contains(e.target)) {
            agencyMenu.classList.add('hidden');
            agencyButton.setAttribute('aria-expanded', 'false');
        }
    });

    // Modal close events
    closeExternalLinkModalButton.addEventListener('click', hideExternalLinkModal);
    cancelExternalLinkButton.addEventListener('click', hideExternalLinkModal);
    confirmExternalLinkButton.addEventListener('click', () => {
        if (currentLink) {
            window.open(currentLink, '_blank');
            hideExternalLinkModal();
        }
    });

    externalLinkModal.addEventListener('click', (e) => {
        if (e.target === externalLinkModal) hideExternalLinkModal();
    });

    closeAddLinkModalButton.addEventListener('click', hideAddLinkModal);
    cancelAddLinkButton.addEventListener('click', hideAddLinkModal);
    addLinkModal.addEventListener('click', (e) => {
        if (e.target === addLinkModal) hideAddLinkModal();
    });

    // Add Link clicks
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('.add-link-btn');
        if (btn) {
            showAddLinkModal(btn.dataset.year, btn.dataset.agency);
        }
    });

    // External Link Handler
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[href^="http"]');
        if (link && link.getAttribute('target') === '_blank' && !link.closest('.custom-link-item')) { 
            e.preventDefault();
            showExternalLinkModal(link.href, link.textContent.trim());
        }
    });

    // Form Submit
    addLinkForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const title = linkTitleInput.value.trim();
        const url = linkUrlInput.value.trim();
        if (!title || !url) return;

        const data = { agency: currentAgency, year: currentYear, title, url };
        try {
            const api_url = editingLinkId ? `${API_BASE_URL}/${editingLinkId}` : API_BASE_URL;
            const method = editingLinkId ? 'PUT' : 'POST';
            
            const response = await fetch(api_url, {
                method: method,
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                const links = await fetchAllLinksForAgency(currentAgency);
                distributeLinks(links, currentAgency);
                hideAddLinkModal();
            }
        } catch (error) {
            console.error('Error saving link:', error);
        }
    });

    // Initialize: Check for active agency and load
    const activeAgency = selectedAgencySpan.textContent.trim();
    if (activeAgency && activeAgency !== 'Select Agency') {
        fetchAllLinksForAgency(activeAgency).then(links => distributeLinks(links, activeAgency));
    }
 });
 </script>

 @endsection