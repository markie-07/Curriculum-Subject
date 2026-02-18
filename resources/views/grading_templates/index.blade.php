@extends('layouts.app')

@section('content')
<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 sm:p-6 md:p-8">
    <div class="max-w-7xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('grade_setup') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 mb-4 transition-colors">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Grade Setup
            </a>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Grading Templates Manager</h1>
                    <p class="text-sm text-gray-600 mt-1">Manage and customize your grading templates.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($templates as $template)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ $template->name }}</h3>
                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-mono text-gray-600 bg-gray-100 rounded border border-gray-200">{{ $template->code }}</span>
                        </div>
                        <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $template->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $template->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-6 line-clamp-2 h-10">{{ $template->description }}</p>
                    
                    <div class="flex justify-between items-center text-sm text-gray-500 border-t border-gray-100 pt-4">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            {{ count($template->components) }} Groups
                        </span>
                        <button type="button" data-template-id="{{ $template->id }}" class="edit-template-btn text-indigo-600 hover:text-indigo-800 font-semibold flex items-center gap-1 transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-[100] hidden overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center p-4" style="display: none; background: rgba(0,0,0,0.5);" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Centering Container -->
    <div class="relative w-full max-w-4xl max-h-[90vh] overflow-hidden bg-white rounded-2xl shadow-2xl flex flex-col" onclick="event.stopPropagation()">
        <!-- Header -->
        <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-100">
            <div>
                <h3 class="text-xl font-bold text-gray-900" id="modal-title">Edit Grading Template</h3>
                <p class="text-xs text-gray-500 mt-0.5">Update template configuration and weights.</p>
            </div>
            <button type="button" onclick="closeModal()" class="p-2 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto flex-1 bg-white">
             <form id="editTemplateForm" class="space-y-8">
                @csrf
                @method('PUT')
                <input type="hidden" id="template_id" name="id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Template Name</label>
                        <input type="text" id="template_name" name="name" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 border">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                        <input type="text" id="template_description" name="description" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 border">
                    </div>
                </div>

                <div class="pt-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800">Grading Periods & Weights</h4>
                        </div>
                        <div id="periodsTotalDisplay" class="text-sm font-bold px-3 py-1 rounded-full bg-gray-100 text-gray-600">
                            Total: <span id="periodsTotal">0</span>%
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 p-5 bg-gray-50 rounded-xl border border-gray-100" id="periodsContainer">
                        <!-- Populated by JS -->
                    </div>
                </div>

                <div class="pt-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-teal-100 text-teal-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-800">Components Configuration</h4>
                        </div>
                        <div id="componentsTotalDisplay" class="text-sm font-bold px-3 py-1 rounded-full bg-gray-100 text-gray-600">
                            Total: <span id="componentsTotal">0</span>%
                        </div>
                    </div>
                    <div id="componentsContainer" class="space-y-4">
                        <!-- Populated by JS -->
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
            <button type="button" onclick="saveTemplate()" class="px-6 py-2.5 rounded-lg bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5">Save Changes</button>
            <button type="button" onclick="closeModal()" class="px-6 py-2.5 rounded-lg bg-white text-gray-700 font-bold border border-gray-200 hover:bg-gray-50 transition-all">Cancel</button>
        </div>
    </div>
</div>

<script>
    let currentTemplate = null;

    // Generic initialization function
    function initGradingTemplatesManager() {
        console.log('Grading Templates Manager: Initializing...');
        // alert('System Ready: Grading Manager Loaded'); // Proof of life
        
        // Attach click handlers to all edit buttons
        const editButtons = document.querySelectorAll('.edit-template-btn');
        console.log('Found ' + editButtons.length + ' edit buttons.');
        
        if (editButtons.length === 0) {
            console.warn('No edit buttons found! Check class names.');
            // alert('Error: No edit buttons found on page.');
        }

        editButtons.forEach(button => {
            // Remove old listeners to prevent duplicates if re-initialized
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            
            newButton.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-template-id');
                console.log('Click event fired for ID: ' + id);
                alert('Success: Button Clicked! ID: ' + id); 
                openEditModal(id);
            });
        });
    }

    // Run initialization immediately if DOM is ready, otherwise wait
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initGradingTemplatesManager);
    } else {
        initGradingTemplatesManager();
    }

    async function openEditModal(id) {
        console.log('Edit starting for ID:', id);
        try {
            // Use route-aware URL if possible, otherwise relative
            const baseUrl = window.location.pathname.includes('/grading-templates') 
                ? window.location.pathname.split('/grading-templates')[0] 
                : '';
            const fetchUrl = `${baseUrl}/grading-templates/${id}`;
            console.log('Fetching from:', fetchUrl);

            const response = await fetch(fetchUrl);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const template = await response.json();
            console.log('Template loaded:', template);
            currentTemplate = template;
            
            // Populate fields with double-check
            const modal = document.getElementById('editModal');
            const idField = document.getElementById('template_id');
            const nameField = document.getElementById('template_name');
            const descField = document.getElementById('template_description');

            if (idField) idField.value = template.id;
            if (nameField) nameField.value = template.name;
            if (descField) descField.value = template.description || '';
            
            renderPeriods(template.periods || {});
            renderComponents(template.components || []);
            
            if (modal) {
                modal.classList.remove('hidden');
                modal.style.display = 'flex'; // Force display flex for centering
                console.log('Success: Modal displayed');
            } else {
                alert('Critical Error: Modal element #editModal not found in DOM');
            }
        } catch (error) {
            console.error('Edit Template Error:', error);
            alert('Error loading template: ' + error.message);
        }
    }

    function closeModal() {
        const modal = document.getElementById('editModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
        currentTemplate = null;
    }

    function renderPeriods(periods) {
        const container = document.getElementById('periodsContainer');
        container.innerHTML = '';
        for (const [key, value] of Object.entries(periods)) {
            container.innerHTML += `
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">${key}</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <input type="number" step="0.01" data-period="${key}" value="${value}" 
                            oninput="updateTotals()"
                            class="period-input block w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-2.5 border pr-8 shadow-sm">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm font-medium">%</span>
                        </div>
                    </div>
                </div>
            `;
        }
        updateTotals();
    }

    function renderComponents(components) {
        const container = document.getElementById('componentsContainer');
        container.innerHTML = '';
        
        components.forEach((comp, index) => {
            const subsHtml = comp.sub_components && comp.sub_components.length ? comp.sub_components.map((sub, subIndex) => `
                <div class="flex items-center gap-4 ml-6 mt-3 pl-4 border-l-2 border-gray-200">
                    <input type="text" value="${sub.name}" class="sub-comp-name-${index}-${subIndex} flex-1 rounded-lg border-gray-300 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 border shadow-sm" placeholder="Sub-component Name">
                    <div class="w-28 relative rounded-md shadow-sm">
                        <input type="number" step="0.01" value="${sub.weight}" 
                            oninput="updateTotals()"
                            class="sub-comp-weight-${index}-${subIndex} sub-comp-input-${index} block w-full rounded-lg border-gray-300 py-2 px-3 text-sm focus:border-indigo-500 focus:ring-indigo-500 border pr-8 shadow-sm">
                        <div class="absolute inset-y-0 right-0 pr-2.5 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-xs font-bold">%</span>
                        </div>
                    </div>
                </div>
            `).join('') : '<div class="ml-10 text-sm text-gray-400 italic mt-2">No sub-components</div>';

            container.innerHTML += `
                <div class="border border-gray-200 rounded-xl p-5 bg-white shadow-sm hover:border-indigo-200 transition-colors">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex-1 flex items-center gap-4">
                            <input type="text" value="${comp.name}" class="comp-name-${index} flex-1 font-bold text-gray-800 rounded-lg border-gray-300 py-2 px-3 focus:border-indigo-500 focus:ring-indigo-500 border shadow-sm" placeholder="Component Name">
                            <div class="w-32 relative rounded-md shadow-sm">
                                <input type="number" step="0.01" value="${comp.weight}" 
                                    oninput="updateTotals()"
                                    class="comp-weight-${index} comp-weight-input block w-full rounded-lg border-gray-300 py-2 px-3 font-semibold text-gray-800 focus:border-indigo-500 focus:ring-indigo-500 border pr-8 shadow-sm">
                                 <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-bold">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    ${comp.sub_components && comp.sub_components.length ? `
                        <div class="bg-gray-50/50 rounded-lg p-3 border border-gray-100 mt-2">
                            <div class="flex items-center justify-between text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 ml-6 pl-4">
                                <span>Sub-components</span>
                                <span class="comp-subtotal-${index}">Subtotal: 0%</span>
                            </div>
                            ${subsHtml}
                        </div>
                    ` : subsHtml}
                </div>
            `;
        });
        updateTotals();
    }

    function updateTotals() {
        const formatNum = (num) => Number(num.toFixed(2));
        const displayNum = (num) => num % 1 === 0 ? num.toFixed(0) : num.toFixed(2);

        // Grading Periods
        let periodTotal = 0;
        document.querySelectorAll('.period-input').forEach(input => {
            periodTotal += parseFloat(input.value) || 0;
        });
        
        const periodDisplay = document.getElementById('periodsTotalDisplay');
        const periodTotalElem = document.getElementById('periodsTotal');
        if (periodTotalElem) periodTotalElem.innerText = displayNum(periodTotal);
        
        if (periodDisplay) {
            if (Math.round(periodTotal * 100) / 100 === 100) {
                periodDisplay.className = 'text-sm font-bold px-3 py-1 rounded-full bg-green-100 text-green-700';
            } else {
                periodDisplay.className = 'text-sm font-bold px-3 py-1 rounded-full bg-red-100 text-red-700 animate-pulse';
            }
        }

        // Components
        let compTotal = 0;
        const compInputs = document.querySelectorAll('.comp-weight-input');
        compInputs.forEach(input => {
            compTotal += parseFloat(input.value) || 0;
        });

        const compDisplay = document.getElementById('componentsTotalDisplay');
        const compTotalElem = document.getElementById('componentsTotal');
        if (compTotalElem) compTotalElem.innerText = displayNum(compTotal);

        if (compDisplay) {
            if (Math.round(compTotal * 100) / 100 === 100) {
                compDisplay.className = 'text-sm font-bold px-3 py-1 rounded-full bg-green-100 text-green-700';
            } else {
                compDisplay.className = 'text-sm font-bold px-3 py-1 rounded-full bg-red-100 text-red-700 animate-pulse';
            }
        }

        // Sub-components validation
        compInputs.forEach((input, index) => {
            const subInputs = document.querySelectorAll(`.sub-comp-input-${index}`);
            if (subInputs.length > 0) {
                let subTotal = 0;
                subInputs.forEach(subInput => {
                    subTotal += parseFloat(subInput.value) || 0;
                });
                
                const subDisplay = document.querySelector(`.comp-subtotal-${index}`);
                if (subDisplay) {
                    subDisplay.innerText = `Subtotal: ${displayNum(subTotal)}%`;
                    if (Math.round(subTotal * 100) / 100 === 100) {
                        subDisplay.className = `comp-subtotal-${index} text-green-600 font-bold`;
                    } else {
                        subDisplay.className = `comp-subtotal-${index} text-red-600 font-bold`;
                    }
                }
            }
        });
    }

    async function saveTemplate() {
        if (!currentTemplate) return;

        // Perform final validation
        let periodTotal = 0;
        document.querySelectorAll('.period-input').forEach(input => {
            periodTotal += parseFloat(input.value) || 0;
        });

        let compTotal = 0;
        document.querySelectorAll('.comp-weight-input').forEach(input => {
            compTotal += parseFloat(input.value) || 0;
        });

        const displayNum = (num) => num % 1 === 0 ? num.toFixed(0) : num.toFixed(2);

        if (Math.round(periodTotal * 100) / 100 !== 100) {
            alert('Error: Grading Periods must sum to exactly 100%. Current total: ' + displayNum(periodTotal) + '%');
            return;
        }

        if (Math.round(compTotal * 100) / 100 !== 100) {
            alert('Error: Component Configuration must sum to exactly 100%. Current total: ' + displayNum(compTotal) + '%');
            return;
        }

        // Sub-component validation
        const compDivs = document.getElementById('componentsContainer').children;
        for (let i = 0; i < compDivs.length; i++) {
            const subInputs = document.querySelectorAll(`.sub-comp-input-${i}`);
            if (subInputs.length > 0) {
                let subTotal = 0;
                subInputs.forEach(si => subTotal += parseFloat(si.value) || 0);
                if (Math.round(subTotal * 100) / 100 !== 100) {
                    const compName = document.querySelector(`.comp-name-${i}`).value;
                    alert(`Error: Sub-components for "${compName}" must sum to exactly 100%. Current total: ${displayNum(subTotal)}%`);
                    return;
                }
            }
        }

        // Collect periods
        const periods = {};
        document.querySelectorAll('.period-input').forEach(input => {
            periods[input.dataset.period] = parseFloat(input.value) || 0;
        });

        // Collect components
        const components = [];
        const compDivs = document.getElementById('componentsContainer').children;
        
        for (let i = 0; i < compDivs.length; i++) {
            const name = document.querySelector(`.comp-name-${i}`).value;
            const weight = parseFloat(document.querySelector(`.comp-weight-${i}`).value) || 0;
            
            // Reconstruct sub-components from original structure but with updated values
            // Currently this UI assumes structure (count of subs) doesn't change, only values/names
            // Ideally we'd add "Add Sub component" buttons, but for now strict edit is safer
            const originalComp = currentTemplate.components[i];
            const subComponents = [];
            if (originalComp && originalComp.sub_components && Array.isArray(originalComp.sub_components)) {
                for (let j = 0; j < originalComp.sub_components.length; j++) {
                    const subNameInput = document.querySelector(`.sub-comp-name-${i}-${j}`);
                    const subWeightInput = document.querySelector(`.sub-comp-weight-${i}-${j}`);
                    
                    if (subNameInput && subWeightInput) {
                        subComponents.push({ 
                            name: subNameInput.value, 
                            weight: parseFloat(subWeightInput.value) || 0 
                        });
                    }
                }
            }

            components.push({
                name: name,
                weight: weight,
                sub_components: subComponents
            });
        }

        const data = {
            id: currentTemplate.id,
            name: document.getElementById('template_name').value,
            description: document.getElementById('template_description').value,
            periods: periods,
            components: components
        };

        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch(`/grading-templates/${currentTemplate.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            if (result.success) {
                alert('Template saved successfully!');
                location.reload();
            } else {
                alert('Error saving: ' + (result.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error saving:', error);
            alert('Failed to save template');
        }
    }
</script>
@endsection
