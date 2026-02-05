@extends('layouts.app')

@section('content')
<div class="p-4 sm:p-6 md:p-8 w-full bg-gray-50 min-h-screen">
    {{-- Page Header --}}
    {{-- Page Header --}}
    <div class="relative mb-8 overflow-hidden bg-white rounded-3xl shadow-lg border border-slate-100">
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50 -mr-16 -mt-16"></div>
        <div class="relative p-8 flex items-center gap-6">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Subject Equivalency Tool</h1>
                <p class="text-slate-500 mt-2 text-lg">Manage and map credit transfers across institutions</p>
            </div>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        {{-- Left Panel: Create Equivalency --}}
        <div class="lg:col-span-4">
            <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden sticky top-8 transition-all hover:shadow-2xl duration-300">
                <div class="h-1.5 bg-gradient-to-r from-blue-500 to-indigo-600"></div>
                <div class="p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-slate-800">New Equivalency</h2>
                        <p class="text-sm text-slate-500 mt-2">Link an external subject to your curriculum.</p>
                    </div>
                    
                    <div class="space-y-6">
                        <div class="group">
                            <label for="source-subject" class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">External Subject Name</label>
                            <div class="relative transition-all duration-300 focus-within:transform focus-within:-translate-y-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v11.494m-5.747-5.747H17.747" /></svg>
                                </span>
                                <input type="text" id="source-subject" placeholder="e.g., Intro to Programming" class="block w-full py-3 pl-11 pr-4 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none shadow-sm">
                            </div>
                        </div>

                        <div class="group">
                            <label for="source-code" class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">External Subject Code</label>
                            <div class="relative transition-all duration-300 focus-within:transform focus-within:-translate-y-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" /></svg>
                                </span>
                                <input type="text" id="source-code" placeholder="e.g., CS101" class="block w-full py-3 pl-11 pr-4 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none shadow-sm">
                            </div>
                        </div>

                        <div class="group">
                            <label for="source-description" class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Description</label>
                            <textarea id="source-description" rows="3" placeholder="Brief subject description..." class="block w-full py-3 px-4 border border-slate-200 bg-slate-50 rounded-xl text-sm focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none shadow-sm resize-none"></textarea>
                        </div>

                        <div class="relative py-4">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t border-slate-200"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-white px-2 text-xs font-bold text-slate-400 uppercase tracking-widest">Maps To</span>
                            </div>
                        </div>

                        <div class="group">
                            <label for="equivalent-subject" class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Internal Subject</label>
                            <div class="relative transition-all duration-300 focus-within:transform focus-within:-translate-y-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                </span>
                                <select id="equivalent-subject" class="block w-full py-3 pl-11 pr-10 border border-slate-200 bg-white rounded-xl text-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all outline-none shadow-sm appearance-none cursor-pointer">
                                    <option value="" disabled selected>-- Select Target Subject --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" data-description="{{ $subject->course_description }}">{{ $subject->subject_code }} - {{ $subject->subject_name }}</option>
                                    @endforeach
                                </select>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </span>
                            </div>
                        </div>

                        <div id="equivalent-description-container" class="hidden animate-fade-in-up">
                            <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    <p id="equivalent-description" class="text-xs text-slate-600 leading-relaxed"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button id="create-equivalency-btn" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all duration-300 shadow-lg shadow-blue-500/30 hover:shadow-blue-500/40 transform hover:-translate-y-0.5 active:translate-y-0">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Create Mapping
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        {{-- Right Panel: Existing Equivalencies --}}
        <div class="lg:col-span-8">
             <div class="bg-white rounded-3xl shadow-xl border border-slate-200 h-full flex flex-col overflow-hidden">
                <div class="p-8 border-b border-slate-100 bg-slate-50/30 backdrop-blur-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-800">Equivalent Mappings</h2>
                            <p class="text-sm text-slate-500 mt-1">{{ count($equivalencies) }} active rules</p>
                        </div>
                        <div class="relative group w-full md:w-72">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="search-equivalency" placeholder="Filter subjects..." class="w-full bg-white border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm text-sm">
                        </div>
                    </div>
                </div>

                <div id="equivalency-list" class="p-6 space-y-4 overflow-y-auto custom-scrollbar flex-1 bg-slate-50/30" style="max-height: 800px;">
                    @forelse ($equivalencies as $item)
                        <div class="equivalency-item group relative bg-white border border-slate-200 rounded-2xl p-5 hover:shadow-lg hover:border-blue-300 transition-all duration-300 cursor-pointer" 
                             data-id="{{ $item->id }}" 
                             data-source-name="{{ $item->source_subject_name }}" 
                             data-source-code="{{ $item->source_subject_code }}" 
                             data-source-description="{{ $item->source_subject_description }}" 
                             data-equivalent-code="{{ $item->equivalentSubject->subject_code }}" 
                             data-equivalent-name="{{ $item->equivalentSubject->subject_name }}" 
                             data-equivalent-description="{{ $item->equivalentSubject->course_description }}" 
                             data-equivalent-id="{{ $item->equivalent_subject_id }}">
                            
                            <div class="flex items-center justify-between gap-4">
                                {{-- Source --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        @if($item->source_subject_code)
                                            <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider border border-slate-200">{{ $item->source_subject_code }}</span>
                                        @endif
                                        <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">External</span>
                                    </div>
                                    <h3 class="font-bold text-slate-700 truncate text-base leading-tight group-hover:text-blue-600 transition-colors" title="{{ $item->source_subject_name }}">{{ $item->source_subject_name }}</h3>
                                </div>

                                {{-- Connector --}}
                                <div class="flex flex-col items-center justify-center shrink-0 w-12 text-slate-300 group-hover:text-blue-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>

                                {{-- Target --}}
                                <div class="flex-1 min-w-0 text-right">
                                    <div class="flex items-center justify-end gap-2 mb-1">
                                        <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">Internal</span>
                                        <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider border border-blue-100">{{ $item->equivalentSubject->subject_code }}</span>
                                    </div>
                                    <h3 class="font-bold text-slate-700 truncate text-base leading-tight" title="{{ $item->equivalentSubject->subject_name }}">{{ $item->equivalentSubject->subject_name }}</h3>
                                </div>
                            </div>
                            
                            {{-- Footer Data --}}
                            <div class="mt-4 pt-3 border-t border-slate-50 flex items-center justify-between text-[11px] text-slate-400">
                                <span>ID: #{{ $item->id }}</span>
                                
                                {{-- Actions --}}
                                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                                    <span class="text-blue-500 font-medium">Click to view details</span>
                                </div>

                                <span>{{ $item->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <div id="no-equivalencies-message" class="flex flex-col items-center justify-center py-16 px-4 text-center border-2 border-dashed border-slate-200 rounded-2xl bg-slate-50/50">
                            <div class="bg-white p-4 rounded-full shadow-sm mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                            </div>
                            <h3 class="text-lg font-medium text-slate-900">No Mappings Found</h3>
                            <p class="mt-2 text-sm text-slate-500 max-w-sm">There are no subject equivalencies configured yet. Use the form on the left to create your first mapping.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Confirmation Modal --}}
<div id="confirmationModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
    <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform scale-95 opacity-0 transition-all duration-300 ease-out" id="confirmation-modal-panel">
        <div id="confirmation-modal-icon" class="w-12 h-12 rounded-full p-2 flex items-center justify-center mx-auto mb-4">
            {{-- Icon will be set by JS --}}
        </div>
        <h3 id="confirmation-modal-title" class="text-lg font-semibold text-slate-800"></h3>
        <p id="confirmation-modal-message" class="text-sm text-slate-500 mt-2"></p>
        <div class="mt-6 flex justify-center gap-4">
            <button id="cancel-confirmation-button" class="w-full px-6 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all">Cancel</button>
            <button id="confirm-action-button" class="w-full px-6 py-2.5 text-sm font-medium text-white rounded-lg transition-all">Confirm</button>
        </div>
    </div>
</div>

{{-- Success Modal --}}
<div id="successModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
     <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform scale-95 opacity-0 transition-all duration-300 ease-out" id="success-modal-panel">
        <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
             <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h3 id="success-modal-title" class="text-lg font-semibold text-slate-800"></h3>
        <p id="success-modal-message" class="text-sm text-slate-500 mt-2"></p>
        <div class="mt-6">
            <button id="closeSuccessModalButton" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all">OK</button>
        </div>
    </div>
</div>

{{-- Description Modal --}}
<div id="descriptionModal" class="fixed inset-0 z-[120] overflow-y-auto bg-slate-900/50 backdrop-blur-sm opacity-0 transition-opacity duration-300 ease-out hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-2xl rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out" id="description-modal-panel">
            <button id="closeDescriptionModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100" aria-label="Close modal">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="text-center mb-8">
                <img src="{{ asset('/images/SMSIII LOGO.png') }}" alt="SMS3 Logo" class="mx-auto h-16 w-auto mb-4">
                <h2 class="text-2xl font-bold text-slate-800">Equivalency Description</h2>
                <p class="text-sm text-slate-500 mt-1">View subject equivalency details.</p>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Source Subject Name</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-slate-200 rounded-lg">
                        <p id="view-source-subject" class="text-gray-800 font-medium"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Source Subject Code</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-slate-200 rounded-lg">
                        <p id="view-source-code" class="text-gray-800 font-medium"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Source Subject Description</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-slate-200 rounded-lg min-h-[80px]">
                        <p id="view-source-description" class="text-gray-700 whitespace-pre-wrap"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Equivalent BCP Subject</label>
                    <div class="w-full px-4 py-3 bg-gray-50 border border-slate-200 rounded-lg">
                        <p id="view-equivalent-subject" class="text-gray-800 font-medium"></p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Equivalent Subject Description</label>
                    <div class="w-full px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg min-h-[80px]">
                        <p id="view-equivalent-description" class="text-gray-700 whitespace-pre-wrap"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
document.addEventListener('DOMContentLoaded', function () {
    const createBtn = document.getElementById('create-equivalency-btn');
    const sourceSubjectInput = document.getElementById('source-subject');
    const sourceCodeInput = document.getElementById('source-code');
    const sourceDescriptionInput = document.getElementById('source-description');
    const equivalentSubjectSelect = document.getElementById('equivalent-subject');
    const equivalentDescriptionContainer = document.getElementById('equivalent-description-container');
    const equivalentDescriptionText = document.getElementById('equivalent-description');
    const equivalencyList = document.getElementById('equivalency-list');
    const searchInput = document.getElementById('search-equivalency');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Debug: Check if button is found
    console.log('Create button found:', createBtn);
    console.log('Button clickable:', createBtn && !createBtn.disabled);
    
    // Modal elements
    const confirmationModal = document.getElementById('confirmationModal');
    const confirmationModalPanel = document.getElementById('confirmation-modal-panel');
    const confirmationModalTitle = document.getElementById('confirmation-modal-title');
    const confirmationModalMessage = document.getElementById('confirmation-modal-message');
    const confirmationModalIcon = document.getElementById('confirmation-modal-icon');
    const cancelConfirmationButton = document.getElementById('cancel-confirmation-button');
    const confirmActionButton = document.getElementById('confirm-action-button');

    const successModal = document.getElementById('successModal');
    const successModalPanel = document.getElementById('success-modal-panel');
    const successModalTitle = document.getElementById('success-modal-title');
    const successModalMessage = document.getElementById('success-modal-message');
    const closeSuccessModalButton = document.getElementById('closeSuccessModalButton');

    const descriptionModal = document.getElementById('descriptionModal');
    const descriptionModalPanel = document.getElementById('description-modal-panel');
    const closeDescriptionModalButton = document.getElementById('closeDescriptionModalButton');
    const viewSourceSubject = document.getElementById('view-source-subject');
    const viewSourceCode = document.getElementById('view-source-code');
    const viewSourceDescription = document.getElementById('view-source-description');
    const viewEquivalentSubject = document.getElementById('view-equivalent-subject');
    const viewEquivalentDescription = document.getElementById('view-equivalent-description');

    let currentAction = null;

    // Debug: Check if modal elements are found
    console.log('Description Modal:', descriptionModal);
    console.log('Equivalency List:', equivalencyList);

    // Modal Helper Functions (MUST be defined before event listeners use them)
    const showSuccessModal = (title, message) => {
        successModalTitle.textContent = title;
        successModalMessage.textContent = message;
        successModal.classList.remove('hidden');
        setTimeout(() => {
            successModal.classList.remove('opacity-0');
            successModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hideSuccessModal = () => {
        successModal.classList.add('opacity-0');
        successModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => successModal.classList.add('hidden'), 300);
    };

    const showConfirmationModal = (config) => {
        confirmationModalTitle.textContent = config.title;
        confirmationModalMessage.textContent = config.message;
        confirmationModalIcon.innerHTML = config.icon;
        confirmActionButton.className = `w-full px-6 py-2.5 text-sm font-medium text-white rounded-lg transition-all ${config.confirmButtonClass}`;
        currentAction = config.onConfirm;

        confirmationModal.classList.remove('hidden');
        setTimeout(() => {
            confirmationModal.classList.remove('opacity-0');
            confirmationModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hideConfirmationModal = () => {
        confirmationModal.classList.add('opacity-0');
        confirmationModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => confirmationModal.classList.add('hidden'), 300);
    };

    const showDescriptionModal = () => {
        descriptionModal.classList.remove('hidden');
        setTimeout(() => {
            descriptionModal.classList.remove('opacity-0');
            descriptionModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hideDescriptionModal = () => {
        descriptionModal.classList.add('opacity-0');
        descriptionModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => descriptionModal.classList.add('hidden'), 300);
    };

    // Auto-display description when equivalent subject is selected
    equivalentSubjectSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const description = selectedOption.getAttribute('data-description');
        
        if (description && description.trim() !== '' && description !== 'null') {
            equivalentDescriptionText.textContent = description;
            equivalentDescriptionContainer.classList.remove('hidden');
        } else {
            equivalentDescriptionText.textContent = 'No description available for this subject.';
            equivalentDescriptionContainer.classList.remove('hidden');
        }
    });

    // Event Listeners for Confirmation Modal Buttons (NOW AFTER helper functions)
    cancelConfirmationButton.addEventListener('click', () => {
        hideConfirmationModal();
        currentAction = null;
    });

    confirmActionButton.addEventListener('click', () => {
        if (currentAction && typeof currentAction === 'function') {
            currentAction();
        }
        hideConfirmationModal();
    });

    // Event Listeners for Success Modal
    closeSuccessModalButton.addEventListener('click', hideSuccessModal);

    // Event Listeners for Description Modal
    closeDescriptionModalButton.addEventListener('click', hideDescriptionModal);




    // --- CARD CREATION ---
    const createEquivalencyCard = (equivalency) => {
        const date = new Date(equivalency.created_at);
        const formattedDate = date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
        
        const card = document.createElement('div');
        card.className = 'equivalency-item group relative bg-white border border-slate-200 rounded-2xl p-5 hover:shadow-lg hover:border-blue-300 transition-all duration-300 cursor-pointer';
        
        card.dataset.id = equivalency.id;
        card.dataset.sourceName = equivalency.source_subject_name;
        card.dataset.sourceCode = equivalency.source_subject_code || '';
        card.dataset.sourceDescription = equivalency.source_subject_description || '';
        card.dataset.equivalentCode = equivalency.equivalent_subject.subject_code;
        card.dataset.equivalentName = equivalency.equivalent_subject.subject_name;
        card.dataset.equivalentDescription = equivalency.equivalent_subject.course_description || '';
        card.dataset.equivalentId = equivalency.equivalent_subject_id;

        const sourceCodeBadge = equivalency.source_subject_code 
            ? `<span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-bold uppercase tracking-wider border border-slate-200">${equivalency.source_subject_code}</span>` 
            : '';

        card.innerHTML = `
            <div class="flex items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        ${sourceCodeBadge}
                        <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">External</span>
                    </div>
                    <h3 class="font-bold text-slate-700 truncate text-base leading-tight group-hover:text-blue-600 transition-colors" title="${equivalency.source_subject_name}">${equivalency.source_subject_name}</h3>
                </div>

                <div class="flex flex-col items-center justify-center shrink-0 w-12 text-slate-300 group-hover:text-blue-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </div>

                <div class="flex-1 min-w-0 text-right">
                    <div class="flex items-center justify-end gap-2 mb-1">
                        <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">Internal</span>
                        <span class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider border border-blue-100">${equivalency.equivalent_subject.subject_code}</span>
                    </div>
                    <h3 class="font-bold text-slate-700 truncate text-base leading-tight" title="${equivalency.equivalent_subject.subject_name}">${equivalency.equivalent_subject.subject_name}</h3>
                </div>
            </div>
            
            <div class="mt-4 pt-3 border-t border-slate-50 flex items-center justify-between text-[11px] text-slate-400">
                <span>ID: #${equivalency.id}</span>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <span class="text-blue-500 font-medium">Click to view details</span>
                </div>
                <span>${formattedDate}</span>
            </div>
        `;
        return card;
    };

    const addEquivalencyToDOM = (equivalency) => {
        const noItemsMessage = document.getElementById('no-equivalencies-message');
        if (noItemsMessage) noItemsMessage.remove();
        const newCard = createEquivalencyCard(equivalency);
        equivalencyList.prepend(newCard);
    };

    // --- API ACTIONS ---
    
    // CREATE
    createBtn.addEventListener('click', function () {
        console.log('Create button clicked!'); // Debug log
        
        const sourceSubject = sourceSubjectInput.value.trim();
        const sourceCode = sourceCodeInput.value.trim();
        const sourceDescription = sourceDescriptionInput.value.trim();
        const equivalentSubjectId = equivalentSubjectSelect.value;

        if (sourceSubject === '' || equivalentSubjectId === '') {
            showConfirmationModal({
                title: 'Missing Information',
                message: 'Please fill out both subject fields before creating an equivalency.',
                icon: `<svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`,
                confirmButtonClass: 'bg-yellow-600 hover:bg-yellow-700',
                onConfirm: () => {}
            });
            return;
        }

        showConfirmationModal({
            title: 'Create Equivalency?',
            message: 'Are you sure you want to create this subject equivalency?',
            icon: `<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
            confirmButtonClass: 'bg-blue-600 hover:bg-blue-700',
            onConfirm: async () => {
                try {
                    const response = await fetch('/api/equivalencies', {
                        method: 'POST',
                        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json'},
                        body: JSON.stringify({ 
                            source_subject_name: sourceSubject,
                            source_subject_code: sourceCode,
                            source_subject_description: sourceDescription,
                            equivalent_subject_id: equivalentSubjectId 
                        })
                    });

                    if (!response.ok) throw new Error((await response.json()).message || 'Failed to create.');

                    const result = await response.json();
                    const newEquivalency = result.equivalency || result;
                    addEquivalencyToDOM(newEquivalency);
                    
                    // Use SweetAlert for success
                    Swal.fire({
                        title: 'Success!',
                        text: 'Equivalency has been created successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    
                    sourceSubjectInput.value = '';
                    sourceCodeInput.value = '';
                    sourceDescriptionInput.value = '';
                    equivalentSubjectSelect.value = '';
                    equivalentDescriptionContainer.classList.add('hidden');
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to create equivalency: ' + error.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });

    // Event Delegation for clicking equivalency cards
    equivalencyList.addEventListener('click', function (e) {
        console.log('Click detected on equivalency list');
        const card = e.target.closest('.equivalency-item');
        console.log('Card found:', card);
        
        if (card) {
            console.log('Card data:', {
                sourceName: card.dataset.sourceName,
                sourceCode: card.dataset.sourceCode,
                sourceDescription: card.dataset.sourceDescription,
                equivalentCode: card.dataset.equivalentCode,
                equivalentName: card.dataset.equivalentName,
                equivalentDescription: card.dataset.equivalentDescription
            });
            
            // Populate modal with data
            viewSourceSubject.textContent = card.dataset.sourceName;
            viewSourceCode.textContent = card.dataset.sourceCode || 'N/A';
            viewSourceDescription.textContent = card.dataset.sourceDescription || 'No description available.';
            viewEquivalentSubject.textContent = `${card.dataset.equivalentCode} - ${card.dataset.equivalentName}`;
            viewEquivalentDescription.textContent = card.dataset.equivalentDescription || 'No description available.';
            
            console.log('About to show modal...');
            showDescriptionModal();
        }
    });



    
    // --- SEARCH ---
    searchInput.addEventListener('input', function () {
        const searchTerm = searchInput.value.toLowerCase();
        const items = equivalencyList.getElementsByClassName('equivalency-item');

        for (let i = 0; i < items.length; i++) {
            const item = items[i];
            const textContent = item.textContent.toLowerCase();
            item.style.display = textContent.includes(searchTerm) ? 'flex' : 'none';
        }
    });
});
</script>
@endsection


