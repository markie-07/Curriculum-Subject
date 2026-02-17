@extends('layouts.app')

@section('content')
<div class="h-full flex flex-col bg-gray-50 dark:bg-gray-900">
    <!-- Header -->
    <header class="bg-gradient-to-r from-blue-700 to-blue-800 text-white shadow-lg flex-shrink-0 z-10">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('grade_setup') }}" class="text-white/80 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold tracking-tight">Grading Templates Manager</h1>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Add new template button (Could be implemented later) -->
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-6 container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($templates as $template)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200 border border-gray-100 dark:border-gray-700">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $template->name }}</h3>
                            <code class="text-xs font-mono text-gray-500 bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded inline-block mt-1">{{ $template->code }}</code>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $template->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6 line-clamp-2 h-10">{{ $template->description }}</p>
                    
                    <div class="flex justify-between items-center text-sm text-gray-500 border-t pt-4 dark:border-gray-700">
                        <span>{{ count($template->components) }} Component Groups</span>
                        <button onclick="editTemplate({{ $template->id }})" class="text-blue-600 hover:text-blue-800 font-medium flex items-center gap-1 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Configuration
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[80vh] overflow-y-auto">
                <div class="sm:flex sm:items-start w-full">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-2xl leading-6 font-bold text-gray-900 dark:text-white mb-6" id="modal-title">Edit Grading Template</h3>
                        
                        <form id="editTemplateForm" class="space-y-6">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="template_id" name="id">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Template Name</label>
                                    <input type="text" id="template_name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 border">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                                    <input type="text" id="template_description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 border">
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Grading Periods & Weights</h4>
                                <div class="grid grid-cols-3 gap-4" id="periodsContainer">
                                    <!-- Populated by JS -->
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Components Configuration</h4>
                                <div id="componentsContainer" class="space-y-4">
                                    <!-- Populated by JS -->
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-gray-700">
                <button type="button" onclick="saveTemplate()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">Save Changes</button>
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentTemplate = null;

    async function editTemplate(id) {
        try {
            const response = await fetch(`/grading-templates/${id}`);
            const template = await response.json();
            currentTemplate = template;
            
            document.getElementById('template_id').value = template.id;
            document.getElementById('template_name').value = template.name;
            document.getElementById('template_description').value = template.description || '';
            
            renderPeriods(template.periods);
            renderComponents(template.components);
            
            document.getElementById('editModal').classList.remove('hidden');
        } catch (error) {
            console.error('Error fetching template:', error);
            alert('Failed to load template data');
        }
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
        currentTemplate = null;
    }

    function renderPeriods(periods) {
        const container = document.getElementById('periodsContainer');
        container.innerHTML = '';
        for (const [key, value] of Object.entries(periods)) {
            container.innerHTML += `
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">${key}</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <input type="number" step="0.01" data-period="${key}" value="${value}" class="period-input block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white px-3 py-2 border pr-8">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">%</span>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    function renderComponents(components) {
        const container = document.getElementById('componentsContainer');
        container.innerHTML = '';
        
        components.forEach((comp, index) => {
            const subsHtml = comp.sub_components && comp.sub_components.length ? comp.sub_components.map((sub, subIndex) => `
                <div class="flex items-center gap-4 ml-8 mt-2">
                    <input type="text" value="${sub.name}" class="sub-comp-name-${index}-${subIndex} flex-1 rounded-md border-gray-300 py-1 px-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white border" placeholder="Sub-component Name">
                    <div class="w-24 relative rounded-md shadow-sm">
                        <input type="number" step="0.01" value="${sub.weight}" class="sub-comp-weight-${index}-${subIndex} block w-full rounded-md border-gray-300 py-1 px-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white border pr-6">
                        <div class="absolute inset-y-0 right-0 pr-1 flex items-center pointer-events-none">
                            <span class="text-gray-500 text-xs">%</span>
                        </div>
                    </div>
                </div>
            `).join('') : '<div class="ml-8 text-sm text-gray-500 italic mt-1">No sub-components</div>';

            container.innerHTML += `
                <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-700/30 dark:border-gray-600">
                    <div class="flex items-center gap-4 mb-2">
                        <input type="text" value="${comp.name}" class="comp-name-${index} flex-1 font-semibold rounded-md border-gray-300 py-2 px-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white border" placeholder="Component Name">
                        <div class="def-number-input number-input w-32 relative rounded-md shadow-sm">
                            <input type="number" step="0.01" value="${comp.weight}" class="comp-weight-${index} block w-full rounded-md border-gray-300 py-2 px-3 dark:bg-gray-700 dark:border-gray-600 dark:text-white border pr-8">
                             <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-bold">%</span>
                            </div>
                        </div>
                    </div>
                    ${subsHtml}
                </div>
            `;
        });
    }

    async function saveTemplate() {
        if (!currentTemplate) return;

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
