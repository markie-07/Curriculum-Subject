@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Color styles for subject types, consistent with the mapping page */
    .subject-tag-major { background-color: #DBEAFE; color: #1E40AF; border: 1px solid #BFDBFE; }
    .subject-tag-minor { background-color: #E9D5FF; color: #5B21B6; border: 1px solid #D8B4FE;}
    .subject-tag-elective { background-color: #FEE2E2; color: #991B1B; border: 1px solid #FECACA;}
    .subject-tag-general { background-color: #FFEDD5; color: #9A3412; border: 1px solid #FED7AA;}
    .subject-tag-default { background-color: #F3F4F6; color: #374151; border: 1px solid #E5E7EB;}
</style>

<main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
    <div>
        <div class="bg-white p-6 rounded-2xl shadow-lg mb-8">
            <div class="flex flex-col md:flex-row justify-between md:items-center">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl font-bold text-gray-800">Set Subject Prerequisites</h1>
                    <p class="text-sm text-gray-500 mt-1">Define the relationships between subjects for a curriculum.</p>
                </div>
                <button id="setPrerequisiteBtn" class="bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg hover:bg-blue-800 transition-colors shadow-md flex items-center gap-2 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Set Prerequisite
                </button>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <div class="mb-6 pb-6 border-b border-gray-200">
                <label for="curriculum-selector-button" class="block text-lg font-semibold text-gray-700 mb-2">Select Subject Category</label>
                <div id="custom-curriculum-selector" class="relative">
                    <button type="button" id="curriculum-selector-button" class="w-full border border-gray-300 rounded-lg p-3 flex justify-between items-center bg-white text-left focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-gray-500 truncate pr-2">-- Select a Curriculum --</span>
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="curriculum-dropdown-panel" class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg hidden">
                        <div class="p-2">
                            <input type="text" id="curriculum-search-input" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Search for a curriculum...">
                        </div>
                        <ul id="curriculum-options-list" class="max-h-60 overflow-y-auto">
                            @foreach($activeCategories as $category)
                                <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer font-semibold text-blue-700 border-b border-slate-100 transition-colors" data-value="{{ $category['id'] }}" data-name="{{ $category['name'] }}">
                                    {{ $category['name'] }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <h2 class="text-xl font-bold text-gray-800 mb-4">Prerequisite Chain</h2>
            <div id="prerequisiteChain" class="space-y-4 text-gray-700">
                <p class="text-center text-gray-500 py-8">Select a curriculum from the dropdown above to view its prerequisite chain.</p>
            </div>
            
            <div class="mt-6 text-right">
                <button id="savePrerequisiteChainBtn" class="bg-green-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-green-700 transition-colors shadow-md hidden disabled:opacity-50 disabled:cursor-not-allowed disabled:bg-gray-400" disabled>
                    <span class="save-btn-text">Save</span>
                    <span class="save-btn-loading hidden flex items-center">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Saving...
                    </span>
                </button>
            </div>

        </div>
    </div>
</main>

{{-- Modal for Setting Prerequisites --}}
<div id="prerequisiteModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-5xl rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out" id="prerequisite-modal-panel">
            <button id="closePrerequisiteModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100" aria-label="Close modal">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="text-center mb-8">
                <img src="{{ asset('/images/SMSIII LOGO.png') }}" alt="SMS3 Logo" class="mx-auto h-16 w-auto mb-4">
                <h2 class="text-2xl font-bold text-slate-800">Set Prerequisites</h2>
                <p class="text-sm text-slate-500 mt-1">Define prerequisite relationships between subjects.</p>
            </div>

            <form id="prerequisiteForm" class="space-y-6">
                @csrf
                <input type="hidden" id="modalCurriculumId" name="curriculum_id">
                <input type="hidden" id="modalSubjectCode" name="subject_code">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-2">
                    <div class="relative z-30">
                        <label for="modal-category-selector-button" class="block text-sm font-medium text-slate-700 mb-2">Select Subject Category</label>
                        <div id="modal-custom-category-selector" class="relative">
                            <button type="button" id="modal-category-selector-button" class="w-full border border-slate-300 rounded-lg p-3 flex justify-between items-center bg-white text-left focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm hover:shadow-md">
                                <span class="text-slate-500 truncate pr-2">-- Select a Subject Category --</span>
                                <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div id="modal-category-dropdown-panel" class="absolute z-50 w-full mt-1 bg-white border border-slate-300 rounded-lg shadow-xl hidden">
                                <ul id="modal-category-options-list" class="max-h-60 overflow-y-auto py-1">
                                    <li class="px-4 py-2 hover:bg-blue-50 cursor-pointer text-slate-700 transition-colors" data-value="general-education" data-name="General Education (NSTP 1, NSTP 2)">
                                        General Education (NSTP 1, NSTP 2)
                                    </li>
                                    <li class="px-4 py-2 hover:bg-slate-50 cursor-pointer text-slate-700 transition-colors" data-value="professional-non-lab" data-name="Professional Subject Non Laboratory">
                                        Professional Subject Non Laboratory
                                    </li>
                                    <li class="px-4 py-2 hover:bg-slate-50 cursor-pointer text-slate-700 transition-colors" data-value="professional-lab" data-name="Professional Subject Laboratory">
                                        Professional Subject Laboratory
                                    </li>
                                    <li class="px-4 py-2 hover:bg-slate-50 cursor-pointer text-slate-700 transition-colors" data-value="professional-board" data-name="Professional Subject Board Courses">
                                        Professional Subject Board Courses
                                    </li>
                                    <li class="px-4 py-2 hover:bg-slate-50 cursor-pointer text-slate-700 transition-colors" data-value="professional-non-board" data-name="Professional Subject Non Board Courses">
                                        Professional Subject Non Board Courses
                                    </li>
                                    <li class="px-4 py-2 hover:bg-slate-50 cursor-pointer text-slate-700 transition-colors" data-value="professional-oc" data-name="Professional Subject OC">
                                        Professional Subject OC
                                    </li>
                                    <li class="px-4 py-2 hover:bg-slate-50 cursor-pointer text-slate-700 transition-colors" data-value="research" data-name="Research">
                                        Research
                                    </li>
                                    <li class="px-4 py-2 hover:bg-slate-50 cursor-pointer text-slate-700 transition-colors" data-value="ojt" data-name="OJT/Practicum">
                                        OJT/Practicum
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative z-20">
                        <label for="modal-subject-selector-button" class="block text-sm font-medium text-slate-700 mb-2">Subject</label>
                        <div id="modal-custom-subject-selector" class="relative">
                            <button type="button" id="modal-subject-selector-button" class="w-full border border-slate-300 rounded-lg p-3 flex justify-between items-center bg-white text-left focus:outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm hover:shadow-md">
                                <span class="text-slate-500 truncate pr-2">Select a curriculum first</span>
                                <svg class="w-5 h-5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div id="modal-subject-dropdown-panel" class="absolute z-40 w-full mt-1 bg-white border border-slate-300 rounded-lg shadow-xl hidden">
                                <div class="p-2 bg-slate-50 border-b border-slate-100 rounded-t-lg">
                                    <input type="text" id="modal-subject-search-input" class="w-full px-3 py-2 border border-slate-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 text-sm" placeholder="Search for a subject...">
                                </div>
                                <ul id="modal-subject-options-list" class="max-h-60 overflow-y-auto py-1">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Pre-requisite to</label>
                    <div id="prerequisiteList" class="max-h-[60vh] overflow-y-auto bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <p class="text-slate-500">Select a subject to see available prerequisites.</p>
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" id="cancelModalBtn" class="flex-1 px-6 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all">Cancel</button>
                    <button type="submit" id="savePrerequisitesBtn" class="flex-1 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all flex items-center justify-center gap-2" disabled>
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <span>Save Prerequisites</span>
                    </button>
                </div>
            </form>
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

{{-- Prerequisite Success Modal --}}
<div id="prerequisiteSuccessModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
    <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl p-8 text-center transform scale-95 opacity-0 transition-all duration-300 ease-out" id="prerequisite-success-modal-panel">
        <div class="w-16 h-16 rounded-full bg-green-100 p-3 flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-800 mb-4">Prerequisites Set Successfully!</h3>
        <p class="text-sm text-slate-600 mb-6">Your prerequisites have been saved successfully.</p>
        
        <div class="flex justify-center">
            <button id="closePrerequisiteSuccessModal" class="w-full px-6 py-3 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 transition-all">
                Great!
            </button>
        </div>
    </div>
</div>

{{-- Compliance Validator Modal --}}
<div id="complianceValidatorModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Proceed to Compliance Validator?</h3>
            <p class="text-sm text-gray-500 mt-2">Prerequisites saved successfully! Do you want to go to the compliance validator to check if your curriculum meets the compliance requirements?</p>
            <div class="mt-6 flex justify-center gap-4">
                <button id="cancelComplianceValidator" class="w-full px-6 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">No</button>
                <button id="confirmComplianceValidator" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Yes</button>
            </div>
        </div>
    </div>
</div>

{{-- Prerequisites Success Modal --}}
<div id="prerequisitesSuccessModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-500 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center">
            <div class="w-12 h-12 rounded-full bg-green-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800">Added Successfully!</h3>
            <p class="text-sm text-gray-500 mt-2">Your prerequisites have been saved successfully!</p>
            <div class="mt-6">
                <button id="closePrerequisitesSuccessModal" class="w-full px-6 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // --- State Management ---
    let allSubjectsForCurriculum = [];
    let selectedCurriculum = { id: null, name: '-- Select a Curriculum --' };
    let selectedModalSubject = { code: null, name: 'Select a Subject' };
    let prerequisiteSequence = []; // Track the order of prerequisite selection
    let prerequisiteMap = {}; // Maps subject -> array of its prerequisite codes
    let dependentMap = {};    // Maps subject -> array of subjects that require it

    // --- Main Page Elements ---
    const setPrerequisiteBtn = document.getElementById('setPrerequisiteBtn');
    const prerequisiteChainContainer = document.getElementById('prerequisiteChain');
    const savePrerequisiteChainBtn = document.getElementById('savePrerequisiteChainBtn');

    // --- Modal Elements ---
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

    let currentAction = null;

    // Modal Helper Functions
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
        setTimeout(() => {
            confirmationModal.classList.add('hidden');
        }, 300);
        
        // Only reset loading state, don't disable button when just closing modal
        resetSaveButtonLoadingState();
    };
    
    const resetSaveButtonLoadingState = () => {
        // Only reset loading animation, keep button enabled if it was enabled
        document.querySelector('.save-btn-text').classList.remove('hidden');
        document.querySelector('.save-btn-loading').classList.add('hidden');
    };
    
    const resetSaveButtonState = () => {
        // Reset loading state and disable button (used after successful save)
        document.querySelector('.save-btn-text').classList.remove('hidden');
        document.querySelector('.save-btn-loading').classList.add('hidden');
        savePrerequisiteChainBtn.disabled = true;
    };
    
    const enableSaveButton = () => {
        savePrerequisiteChainBtn.disabled = false;
    };

    // Prerequisite Success Modal Functions
    const prerequisiteSuccessModal = document.getElementById('prerequisiteSuccessModal');
    const prerequisiteSuccessModalPanel = document.getElementById('prerequisite-success-modal-panel');
    const prerequisiteSuccessSubjectName = document.getElementById('prerequisiteSuccessSubjectName');
    const prerequisiteSuccessSubjectCode = document.getElementById('prerequisiteSuccessSubjectCode');
    const prerequisiteSuccessCurriculumName = document.getElementById('prerequisiteSuccessCurriculumName');
    const closePrerequisiteSuccessModal = document.getElementById('closePrerequisiteSuccessModal');
    const addAnotherPrerequisite = document.getElementById('addAnotherPrerequisite');

    const showPrerequisiteSuccessModal = () => {
        prerequisiteSuccessModal.classList.remove('hidden');
        setTimeout(() => {
            prerequisiteSuccessModal.classList.remove('opacity-0');
            prerequisiteSuccessModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hidePrerequisiteSuccessModal = () => {
        prerequisiteSuccessModal.classList.add('opacity-0');
        prerequisiteSuccessModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => prerequisiteSuccessModal.classList.add('hidden'), 300);
    };

    // Modal Event Listeners
    cancelConfirmationButton.addEventListener('click', hideConfirmationModal);
    confirmActionButton.addEventListener('click', () => {
        if (currentAction) currentAction();
        hideConfirmationModal();
    });
    closeSuccessModalButton.addEventListener('click', hideSuccessModal);
    
    // Prerequisite Success Modal Event Listeners
    closePrerequisiteSuccessModal.addEventListener('click', hidePrerequisiteSuccessModal);
    
    // Compliance Validator Modal Event Listeners
    document.getElementById('cancelComplianceValidator').addEventListener('click', () => {
        document.getElementById('complianceValidatorModal').classList.add('hidden');
        document.getElementById('prerequisitesSuccessModal').classList.remove('hidden');
        // Disable save button since prerequisites have been saved
        resetSaveButtonState();
    });
    
    document.getElementById('confirmComplianceValidator').addEventListener('click', () => {
        // Disable save button since prerequisites have been saved
        resetSaveButtonState();
        window.location.href = '{{ route('compliance.validator') }}';
    });
    
    // Prerequisites Success Modal Event Listener
    document.getElementById('closePrerequisitesSuccessModal').addEventListener('click', () => {
        document.getElementById('prerequisitesSuccessModal').classList.add('hidden');
        // Disable save button since prerequisites have been saved
        resetSaveButtonState();
    });
    
    // --- Main Curriculum Searchable Dropdown Elements ---
    const mainCustomSelector = document.getElementById('custom-curriculum-selector');
    const mainSelectorButton = document.getElementById('curriculum-selector-button');
    const mainDropdownPanel = document.getElementById('curriculum-dropdown-panel');
    const mainSearchInput = document.getElementById('curriculum-search-input');
    const mainOptionsList = document.getElementById('curriculum-options-list');

    // --- Modal Elements ---
    const prerequisiteModal = document.getElementById('prerequisiteModal');
    const modalPanel = prerequisiteModal.querySelector('.transform');
    const cancelModalBtn = document.getElementById('cancelModalBtn');
    const modalCurriculumIdInput = document.getElementById('modalCurriculumId');
    const modalSubjectCodeInput = document.getElementById('modalSubjectCode');
    const prerequisiteList = document.getElementById('prerequisiteList');
    const prerequisiteForm = document.getElementById('prerequisiteForm');
    const savePrerequisitesBtn = document.getElementById('savePrerequisitesBtn');
    
    // Global variable to store subjects of the currently selected category
    let currentCategorySubjects = [];
    
    // --- Modal Category Searchable Dropdown Elements ---
    const modalCategoryCustomSelector = document.getElementById('modal-custom-category-selector');
    const modalCategorySelectorButton = document.getElementById('modal-category-selector-button');
    const modalCategoryDropdownPanel = document.getElementById('modal-category-dropdown-panel');
    const modalCategoryOptionsList = document.getElementById('modal-category-options-list');
    
    // --- Modal Subject Searchable Dropdown Elements ---
    const modalCustomSelector = document.getElementById('modal-custom-subject-selector');
    const modalSelectorButton = document.getElementById('modal-subject-selector-button');
    const modalDropdownPanel = document.getElementById('modal-subject-dropdown-panel');
    const modalSearchInput = document.getElementById('modal-subject-search-input');
    const modalOptionsList = document.getElementById('modal-subject-options-list');
    
    // --- New Modals for Saving Workflow ---
    const savePrerequisiteModal = document.getElementById('savePrerequisiteModal');
    const cancelSavePrerequisite = document.getElementById('cancelSavePrerequisite');
    const confirmSavePrerequisite = document.getElementById('confirmSavePrerequisite');
    const proceedToComplianceValidatorModal = document.getElementById('proceedToComplianceValidatorModal');
    const declineProceedToComplianceValidator = document.getElementById('declineProceedToComplianceValidator');
    const confirmProceedToComplianceValidator = document.getElementById('confirmProceedToComplianceValidator');

    // --- Main Curriculum Dropdown Logic ---
    mainSelectorButton.addEventListener('click', (e) => {
        e.stopPropagation();
        mainDropdownPanel.classList.toggle('hidden');
    });

    mainSearchInput.addEventListener('input', () => {
        const filter = mainSearchInput.value.toLowerCase();
        mainOptionsList.querySelectorAll('li').forEach(option => {
            option.style.display = option.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    mainOptionsList.addEventListener('click', (e) => {
        if (e.target.tagName === 'LI') {
            selectedCurriculum.id = e.target.dataset.value;
            selectedCurriculum.name = e.target.dataset.name;
            mainSelectorButton.querySelector('span').textContent = selectedCurriculum.name;
            mainSelectorButton.querySelector('span').classList.remove('text-gray-500');
            mainDropdownPanel.classList.add('hidden');
            fetchPrerequisiteData(selectedCurriculum.id);
        }
    });

    document.addEventListener('click', (e) => {
        if (!mainCustomSelector.contains(e.target)) mainDropdownPanel.classList.add('hidden');
        if (!modalCustomSelector.contains(e.target)) modalDropdownPanel.classList.add('hidden');
        if (!modalCategoryCustomSelector.contains(e.target)) modalCategoryDropdownPanel.classList.add('hidden');
    });

    // --- Modal Category Dropdown Logic ---
    modalCategorySelectorButton.addEventListener('click', (e) => {
        e.stopPropagation();
        modalCategoryDropdownPanel.classList.toggle('hidden');
    });

    modalCategoryOptionsList.addEventListener('click', (e) => {
        if (e.target.tagName === 'LI') {
            const categoryValue = e.target.dataset.value;
            const categoryName = e.target.dataset.name;
            
            // Update modal category selection
            modalCategorySelectorButton.querySelector('span').textContent = categoryName;
            modalCategorySelectorButton.querySelector('span').classList.remove('text-slate-500');
            modalCategoryDropdownPanel.classList.add('hidden');
            
            // Reset subject selection
            selectedModalSubject.code = null;
            selectedModalSubject.name = 'Select a Subject';
            modalSelectorButton.querySelector('span').textContent = 'Select a Subject';
            modalSelectorButton.querySelector('span').classList.add('text-slate-500');
            
            // Clear prerequisite list
            prerequisiteList.innerHTML = '<p class="text-slate-500">Select a subject to see available prerequisites.</p>';
            savePrerequisitesBtn.disabled = true;
            
            // Fetch subjects for this category
            fetchSubjectsForCategory(categoryValue);
        }
    });

    // --- Modal Subject Dropdown Logic ---
    modalSelectorButton.addEventListener('click', (e) => {
        e.stopPropagation();
        modalDropdownPanel.classList.toggle('hidden');
    });

    modalSearchInput.addEventListener('input', () => {
        const filter = modalSearchInput.value.toLowerCase();
        modalOptionsList.querySelectorAll('li').forEach(option => {
            option.style.display = option.textContent.toLowerCase().includes(filter) ? '' : 'none';
        });
    });

    modalOptionsList.addEventListener('click', (e) => {
        // Find the closest LI element (in case user clicks on badge or inner div)
        const li = e.target.closest('li');
        if (li && li.dataset.value) {
            selectedModalSubject.code = li.dataset.value;
            selectedModalSubject.name = li.dataset.name;
            modalSelectorButton.querySelector('span').textContent = selectedModalSubject.name;
            modalSelectorButton.querySelector('span').classList.remove('text-gray-500');
            modalDropdownPanel.classList.add('hidden');
            handleSubjectSelection(selectedModalSubject.code);
        }
    });

    // --- Modal Controls ---
    const showModal = (subjectCodeToEdit = null, curriculumIdFromEdit = null) => {
        // Reset modal to default state (category-based selection)
        modalCurriculumIdInput.value = selectedCurriculum.id;
        modalCategorySelectorButton.querySelector('span').textContent = '-- Select a Subject Category --';
        modalCategorySelectorButton.querySelector('span').classList.add('text-slate-500');
        modalSelectorButton.querySelector('span').textContent = 'Select a category first';
        modalSelectorButton.querySelector('span').classList.add('text-slate-500');
        prerequisiteList.innerHTML = '<p class="text-slate-500">Select a category and subject to see available prerequisites.</p>';
        
        prerequisiteModal.classList.remove('hidden');
        setTimeout(() => modalPanel.classList.remove('opacity-0', 'scale-95'), 10);
    };

    const hideModal = () => {
        modalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            prerequisiteModal.classList.add('hidden');
            prerequisiteForm.reset();
            modalOptionsList.innerHTML = '';
            prerequisiteList.innerHTML = '<p class="text-slate-500">Select a category and subject to see available prerequisites.</p>';
            
            // Reset category dropdown
            modalCategorySelectorButton.querySelector('span').textContent = '-- Select a Subject Category --';
            modalCategorySelectorButton.querySelector('span').classList.add('text-slate-500');
            
            // Reset subject dropdown
            modalSelectorButton.querySelector('span').textContent = 'Select a category first';
            modalSelectorButton.querySelector('span').classList.add('text-slate-500');
            
            savePrerequisitesBtn.disabled = true;
            // Reset prerequisite sequence
            prerequisiteSequence = [];
        }, 300);
    };

    setPrerequisiteBtn.addEventListener('click', () => showModal());
    cancelModalBtn.addEventListener('click', hideModal);
    document.getElementById('closePrerequisiteModalButton').addEventListener('click', hideModal);
    prerequisiteModal.addEventListener('click', (e) => {
        if (e.target === prerequisiteModal) hideModal();
    });

    // --- Data Fetching and UI Rendering ---
    async function fetchPrerequisiteData(curriculumId) {
        if (!curriculumId) {
            prerequisiteChainContainer.innerHTML = '<p class="text-center text-gray-500 py-8">Select a curriculum from the dropdown above to view its prerequisite chain.</p>';
            return;
        }

        prerequisiteChainContainer.innerHTML = '<p class="text-center text-gray-500 py-8">Loading chain...</p>';

        try {
            // Define Virtual IDs
            const virtualIds = [
                'gen-ed-college', 'gen-ed-shs',
                'prof-non-lab', 'prof-lab', 'prof-board', 'prof-non-board', 'prof-oc',
                'research', 'ojt'
            ];
            
            // Handle Virtual IDs
            let apiUrl = `/api/prerequisites/${curriculumId}`;
            if (virtualIds.includes(curriculumId)) {
                apiUrl = `/api/gen-ed-prerequisites/${curriculumId}`;
            }
            
            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error('Failed to fetch data.');
            
            const data = await response.json();
            
            // Filter Regular Curriculums
            let subjects = data.subjects || [];
            if (!virtualIds.includes(curriculumId)) {
                subjects = subjects.filter(s => s.subject_type === 'Major');
            }
            
            renderPrerequisiteChain(data.prerequisites || {}, subjects);
        } catch (error) {
            console.error('Error fetching prerequisite data:', error);
            prerequisiteChainContainer.innerHTML = '<p class="text-center text-red-500 py-8">Could not load prerequisite data.</p>';
        }
    }

    async function fetchPrerequisiteDataAfterSave(curriculumId) {
        try {
            // Define Virtual IDs
            const virtualIds = [
                'gen-ed-college', 'gen-ed-shs',
                'prof-non-lab', 'prof-lab', 'prof-board', 'prof-non-board', 'prof-oc',
                'research', 'ojt'
            ];
            
            // Handle Virtual IDs
            let apiUrl = `/api/prerequisites/${curriculumId}`;
            if (virtualIds.includes(curriculumId)) {
                apiUrl = `/api/gen-ed-prerequisites/${curriculumId}`;
            }
            
            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error('Failed to fetch data.');
            
            const data = await response.json();
             
             // Filter Regular Curriculums
            let subjects = data.subjects || [];
            if (!virtualIds.includes(curriculumId)) {
                subjects = subjects.filter(s => s.subject_type === 'Major');
            }

            renderPrerequisiteChain(data.prerequisites || {}, subjects, false); // Don't disable save button
        } catch (error) {
            console.error('Error fetching prerequisite data after save:', error);
            prerequisiteChainContainer.innerHTML = '<p class="text-center text-red-500 py-8">Could not load prerequisite data.</p>';
        }
    }

    async function fetchSubjectsForModal(curriculumId) {
        // Define all virtual IDs
        const virtualIds = [
            'gen-ed-college', 'gen-ed-shs',
            'prof-non-lab', 'prof-lab', 'prof-board', 'prof-non-board', 'prof-oc',
            'research', 'ojt'
        ];
        
        // Handle all virtual IDs (General Education and Category-based)
        if (virtualIds.includes(curriculumId)) {
            try {
                const response = await fetch(`/api/gen-ed-prerequisites/${curriculumId}`);
                if (!response.ok) {
                    const errText = await response.text();
                    try {
                        const jsonErr = JSON.parse(errText);
                        throw new Error(jsonErr.error || `Server Error: ${response.status}`);
                    } catch (e) {
                        throw new Error(`Server Error: ${response.status}`);
                    }
                }
                
                const data = await response.json();
                allSubjectsForCurriculum = data.subjects || [];
                populateSubjectDropdown(allSubjectsForCurriculum);
            } catch (error) {
                console.error('Error fetching subjects for modal:', error);
                modalOptionsList.innerHTML = `<li class="px-4 py-2 text-red-500">Error: ${error.message}</li>`;
            }
            return;
        }

        try {
            const response = await fetch(`/api/prerequisites/${curriculumId}`);
            if (!response.ok) throw new Error('Failed to fetch subjects.');
            
            const data = await response.json();
            allSubjectsForCurriculum = data.subjects || [];
            
            // Filter dropdown to show only Major subjects
            const dropdownSubjects = allSubjectsForCurriculum.filter(s => s.subject_type === 'Major');
            populateSubjectDropdown(dropdownSubjects);
        } catch (error) {
            console.error('Error fetching subjects for modal:', error);
            modalOptionsList.innerHTML = '<li>Could not load subjects</li>';
        }
    }

    // New function to fetch subjects based on category
    async function fetchSubjectsForCategory(categoryValue) {
        try {
            // Dictionary to map categories to virtual IDs for global/category-based editing
            const categoryToVirtualId = {
                'general-education': 'gen-ed-college',
                'professional-non-lab': 'prof-non-lab',
                'professional-lab': 'prof-lab',
                'professional-board': 'prof-board',
                'professional-non-board': 'prof-non-board',
                'professional-oc': 'prof-oc',
                'research': 'research',
                'ojt': 'ojt'
            };

            // Fetch all subjects from the current curriculum OR determine virtual ID
            let curriculumId = selectedCurriculum.id;
            
            // PRIORITY: If the selected category maps to a Virtual ID (Global Category), use it!
            // This ensures we fetch the correct global subjects (e.g., Prof Lab) instead of 
            // relying on the main dropdown which might be set to 'General Education'.
            if (categoryToVirtualId[categoryValue]) {
                curriculumId = categoryToVirtualId[categoryValue];
                // Update hidden input so handleSubjectSelection works correctly
                modalCurriculumIdInput.value = curriculumId;
            } 
            else if (!curriculumId) {
                modalOptionsList.innerHTML = '<li class="px-4 py-2 text-orange-600">⚠️ Please select a curriculum first</li>';
                modalSelectorButton.querySelector('span').textContent = 'Select a curriculum first';
                modalSelectorButton.disabled = true;
                return;
            }

            // Show loading state
            modalOptionsList.innerHTML = '<li class="px-4 py-2 text-gray-500">Loading subjects...</li>';
            modalSelectorButton.querySelector('span').textContent = 'Loading...';
            modalSelectorButton.disabled = true;

            // DETERMINE CORRECT API ENDPOINT
            let apiUrl = `/api/prerequisites/${curriculumId}`;
            // check if it's one of our virtual IDs (including shs gen ed which isn't in the map above default)
            const virtualIds = Object.values(categoryToVirtualId).concat(['gen-ed-shs']);
            
            if (virtualIds.includes(curriculumId)) {
                apiUrl = `/api/gen-ed-prerequisites/${curriculumId}`;
            }

            const response = await fetch(apiUrl);
            if (!response.ok) throw new Error('Failed to fetch subjects.');
            
            const data = await response.json();
            let allSubjects = data.subjects || [];
            
            console.log('All subjects fetched:', allSubjects.length);
            if (allSubjects.length > 0) {
                console.log('Sample subject:', allSubjects[0]);
                console.log('Sample classification:', allSubjects[0].course_classification);
            }
            console.log('Selected category value:', categoryValue);
            
            // Filter subjects based on category using course_classification field
            // Using case-insensitive and trimmed comparison for robustness
            let filteredSubjects = [];
            
            switch(categoryValue) {
                case 'general-education':
                    // Filter for NSTP 1 and NSTP 2 or General Education
                    filteredSubjects = allSubjects.filter(s => {
                        const classification = (s.course_classification || '').toLowerCase().trim();
                        return classification === 'nstp 1' || classification === 'nstp 2' || classification === 'general education';
                    });
                    break;
                    
                case 'professional-non-lab':
                    filteredSubjects = allSubjects.filter(s => {
                        const classification = (s.course_classification || '').toLowerCase().trim();
                        return classification === 'professional subject non laboratory';
                    });
                    break;
                    
                case 'professional-lab':
                    filteredSubjects = allSubjects.filter(s => {
                        const classification = (s.course_classification || '').toLowerCase().trim();
                        return classification === 'professional subject laboratory';
                    });
                    break;
                    
                case 'professional-board':
                    filteredSubjects = allSubjects.filter(s => {
                        const classification = (s.course_classification || '').toLowerCase().trim();
                        return classification === 'professional subject board courses';
                    });
                    break;
                    
                case 'professional-non-board':
                    filteredSubjects = allSubjects.filter(s => {
                        const classification = (s.course_classification || '').toLowerCase().trim();
                        return classification === 'professional subject non board courses';
                    });
                    break;
                    
                case 'professional-oc':
                    filteredSubjects = allSubjects.filter(s => {
                        const classification = (s.course_classification || '').toLowerCase().trim();
                        return classification === 'professional subject oc';
                    });
                    break;
                    
                case 'research':
                    filteredSubjects = allSubjects.filter(s => {
                        const classification = (s.course_classification || '').toLowerCase().trim();
                        return classification === 'research';
                    });
                    break;
                    
                case 'ojt':
                    filteredSubjects = allSubjects.filter(s => {
                        const classification = (s.course_classification || '').toLowerCase().trim();
                        return classification === 'ojt/practicum';
                    });
                    break;
                    
                default:
                    filteredSubjects = allSubjects;
            }
            
            console.log('Filtered subjects count:', filteredSubjects.length);
            
            if (filteredSubjects.length === 0) {
                modalOptionsList.innerHTML = `<li class="px-4 py-2 text-gray-500">No subjects found for this category</li>`;
                modalSelectorButton.querySelector('span').textContent = 'No subjects available';
                modalSelectorButton.disabled = true;
                // Still store all subjects so prerequisites work if needed? actually filtered is empty so user can't select subject anyway.
                allSubjectsForCurriculum = allSubjects;
                currentCategorySubjects = []; 
            } else {
                allSubjectsForCurriculum = allSubjects;
                currentCategorySubjects = filteredSubjects;
                populateSubjectDropdown(filteredSubjects);
            }
            
        } catch (error) {
            console.error('Error fetching subjects for category:', error);
            modalOptionsList.innerHTML = `<li class="px-4 py-2 text-red-500">Error: ${error.message}</li>`;
            modalSelectorButton.querySelector('span').textContent = 'Error loading subjects';
            modalSelectorButton.disabled = true;
        }
    }

    function populateSubjectDropdown(subjects) {
        modalOptionsList.innerHTML = '';
        modalSelectorButton.querySelector('span').textContent = subjects.length > 0 ? 'Select a Subject' : 'No subjects available';
        modalSelectorButton.disabled = subjects.length === 0;

        if (subjects.length === 0) {
            return;
        }

        // Fetch prerequisite data to show status badges
        let subjectsWithPrerequisites = new Set();
        let subjectsUsedAsPrerequisites = new Set();
        let dropdownPrerequisiteMap = {}; // Maps subject -> array of its prerequisite codes
        let dropdownDependentMap = {};    // Maps subject -> array of subjects that require it
        
        // Determine correct API endpoint based on ID format
        const virtualIds = [
            'gen-ed-college', 'gen-ed-shs',
            'prof-non-lab', 'prof-lab', 'prof-board', 'prof-non-board', 'prof-oc',
            'research', 'ojt'
        ];
        
        let apiUrl = `/api/prerequisites/${modalCurriculumIdInput.value}`;
        if (virtualIds.includes(modalCurriculumIdInput.value)) {
            apiUrl = `/api/gen-ed-prerequisites/${modalCurriculumIdInput.value}`;
        }
        
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                // Build maps of prerequisite relationships
                if (data.prerequisites) {
                    Object.keys(data.prerequisites).forEach(subjectCode => {
                        if (data.prerequisites[subjectCode].length > 0) {
                            subjectsWithPrerequisites.add(subjectCode);
                            
                            // Store the prerequisite codes for this subject
                            dropdownPrerequisiteMap[subjectCode] = data.prerequisites[subjectCode].map(p => p.prerequisite_subject_code);
                            
                            // Track which subjects are used as prerequisites and by whom
                            data.prerequisites[subjectCode].forEach(prereq => {
                                const prereqCode = prereq.prerequisite_subject_code;
                                subjectsUsedAsPrerequisites.add(prereqCode);
                                
                                if (!dropdownDependentMap[prereqCode]) {
                                    dropdownDependentMap[prereqCode] = [];
                                }
                                dropdownDependentMap[prereqCode].push(subjectCode);
                            });
                        }
                    });
                }
                renderSubjectDropdown();
            })
            .catch(error => {
                console.error('Error fetching prerequisite status for dropdown:', error);
                renderSubjectDropdown();
            });

        function renderSubjectDropdown() {
            modalOptionsList.innerHTML = '';
            
            // Group subjects by year and semester
            const subjectsByYearSemester = {};
            subjects.forEach(subject => {
                const year = subject.pivot?.year || 'Unassigned';
                const semester = subject.pivot?.semester || 'Unassigned';
                const key = `${year}-${semester}`;
                
                if (!subjectsByYearSemester[key]) {
                    subjectsByYearSemester[key] = {
                        year: year,
                        semester: semester,
                        subjects: []
                    };
                }
                subjectsByYearSemester[key].subjects.push(subject);
            });

            // Sort the groups by year and semester
            const sortedGroups = Object.values(subjectsByYearSemester).sort((a, b) => {
                if (a.year === 'Unassigned') return 1;
                if (b.year === 'Unassigned') return -1;
                if (a.year !== b.year) return parseInt(a.year) - parseInt(b.year);
                return parseInt(a.semester) - parseInt(b.semester);
            });

            // Create sections for each year-semester group
            sortedGroups.forEach(group => {
                // Create section header
                let headerText = '';
                if (group.year === 'Unassigned') {
                    // Skip header for Unassigned
                } else {
                    const yearSuffix = group.year == 1 ? 'st' : group.year == 2 ? 'nd' : group.year == 3 ? 'rd' : 'th';
                    const semesterName = group.semester == 1 ? 'First' : 'Second';
                    headerText = `${group.year}${yearSuffix} Year - ${semesterName} Semester`;
                }
                
                // Only append header if it has text
                if (headerText) {
                    const headerLi = document.createElement('li');
                    headerLi.className = 'px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 border-b border-slate-200';
                    headerLi.textContent = headerText;
                    headerLi.style.cursor = 'default';
                    modalOptionsList.appendChild(headerLi);
                }

                // Add subjects for this section
                group.subjects.forEach(subject => {
                    const hasPrerequisites = subjectsWithPrerequisites.has(subject.subject_code);
                    const isUsedAsPrerequisite = subjectsUsedAsPrerequisites.has(subject.subject_code);
                    
                    // Get prerequisite and dependent codes for this subject
                    const prereqCodes = dropdownPrerequisiteMap[subject.subject_code] || [];
                    const dependentCodes = dropdownDependentMap[subject.subject_code] || [];
                    
                    const isDisabled = hasPrerequisites || isUsedAsPrerequisite;

                    const li = document.createElement('li');
                    if (isDisabled) {
                        li.className = 'px-4 py-2 bg-gray-50 text-gray-400 pl-6 cursor-not-allowed border-b border-gray-100 block';
                        li.style.pointerEvents = 'none'; // Prevent clicks
                    } else {
                        li.className = 'px-4 py-2 hover:bg-blue-100 cursor-pointer pl-6 transition-colors border-b border-gray-100 block';
                    }
                    
                    li.dataset.value = subject.subject_code;
                    const subjectName = `${subject.subject_name} (${subject.subject_code})`;
                    li.dataset.name = subjectName;
                    
                    // Create HTML with subject code badges
                    li.innerHTML = `
                        <div class="flex items-center justify-between gap-2">
                            <span class="flex-1">${subject.subject_name} (${subject.subject_code}) ${isDisabled ? '<span class="text-xs font-normal italic ml-2">(Configured)</span>' : ''}</span>
                            <div class="flex items-center gap-1 flex-shrink-0 flex-wrap">
                                ${prereqCodes.length > 0
                                    ? prereqCodes.map(code => 
                                        `<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200" title="Requires: ${code}">↓${code}</span>`
                                      ).join('')
                                    : ''
                                }
                                ${dependentCodes.length > 0
                                    ? dependentCodes.map(code => 
                                        `<span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-500 border border-gray-200" title="Required by: ${code}">↑${code}</span>`
                                      ).join('')
                                    : ''
                                }
                            </div>
                        </div>
                    `;
                    
                    modalOptionsList.appendChild(li);
                });
            });
        }
    }

    function populatePrerequisiteButtons(selectedSubjectCode, existingPrerequisites = []) {
        prerequisiteList.innerHTML = '';
        
        // Use currentCategorySubjects to ensure candidates are from the same category
        // This satisfies the requirement: "only the subject that similar Subject Category will display"
        let eligibleSubjects = currentCategorySubjects.filter(s => s.subject_code !== selectedSubjectCode);

        if (eligibleSubjects.length === 0) {
            prerequisiteList.innerHTML = '<p class="text-gray-500">No other subjects available to be prerequisites.</p>';
            return;
        }

        // Initialize sequence for existing prerequisites
        prerequisiteSequence = [...existingPrerequisites];


        // Fetch current prerequisites data to show which subjects have prerequisites and are prerequisites
        let subjectsWithPrerequisites = new Set();
        let subjectsUsedAsPrerequisites = new Set();
        prerequisiteMap = {}; // Maps subject -> array of its prerequisite codes
        dependentMap = {};    // Maps subject -> array of subjects that require it
        
        // Determine correct API endpoint based on ID format
        const virtualIds = [
            'gen-ed-college', 'gen-ed-shs',
            'prof-non-lab', 'prof-lab', 'prof-board', 'prof-non-board', 'prof-oc',
            'research', 'ojt'
        ];
        
        let apiUrl = `/api/prerequisites/${modalCurriculumIdInput.value}`;
        if (virtualIds.includes(modalCurriculumIdInput.value)) {
            apiUrl = `/api/gen-ed-prerequisites/${modalCurriculumIdInput.value}`;
        }
        
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                // Build maps of prerequisite relationships
                if (data.prerequisites) {
                    Object.keys(data.prerequisites).forEach(subjectCode => {
                        if (data.prerequisites[subjectCode].length > 0) {
                            subjectsWithPrerequisites.add(subjectCode);
                            
                            // Store the prerequisite codes for this subject
                            prerequisiteMap[subjectCode] = data.prerequisites[subjectCode].map(p => p.prerequisite_subject_code);
                            
                            // Track which subjects are used as prerequisites and by whom
                            data.prerequisites[subjectCode].forEach(prereq => {
                                const prereqCode = prereq.prerequisite_subject_code;
                                subjectsUsedAsPrerequisites.add(prereqCode);
                                
                                if (!dependentMap[prereqCode]) {
                                    dependentMap[prereqCode] = [];
                                }
                                dependentMap[prereqCode].push(subjectCode);
                            });
                        }
                    });
                }
                renderPrerequisiteButtons();
            })
            .catch(error => {
                console.error('Error fetching prerequisite status:', error);
                renderPrerequisiteButtons();
            });

        function renderPrerequisiteButtons() {
            prerequisiteList.innerHTML = '';
            
            // Group subjects by year and semester
            const subjectsByYearSemester = {};
            eligibleSubjects.forEach(subject => {
                const year = subject.pivot?.year || 'Unassigned';
                const semester = subject.pivot?.semester || 'Unassigned';
                const key = `${year}-${semester}`;
                
                if (!subjectsByYearSemester[key]) {
                    subjectsByYearSemester[key] = {
                        year: year,
                        semester: semester,
                        subjects: []
                    };
                }
                subjectsByYearSemester[key].subjects.push(subject);
            });

            // Sort the groups by year and semester
            const sortedGroups = Object.values(subjectsByYearSemester).sort((a, b) => {
                if (a.year === 'Unassigned') return 1;
                if (b.year === 'Unassigned') return -1;
                if (a.year !== b.year) return parseInt(a.year) - parseInt(b.year);
                return parseInt(a.semester) - parseInt(b.semester);
            });

            // Create sections for each year-semester group
            sortedGroups.forEach(group => {
                // Create section header
                const sectionHeader = document.createElement('div');
                sectionHeader.className = 'mb-3 mt-4 first:mt-0';
                
                let headerText = '';
                if (group.year === 'Unassigned') {
                    // Skip header text for unassigned
                } else {
                    const yearSuffix = group.year == 1 ? 'st' : group.year == 2 ? 'nd' : group.year == 3 ? 'rd' : 'th';
                    const semesterName = group.semester == 1 ? 'First' : 'Second';
                    headerText = `${group.year}${yearSuffix} Year - ${semesterName} Semester`;
                }
                
                if (headerText) {
                    sectionHeader.innerHTML = `
                        <h4 class="text-sm font-semibold text-slate-700 mb-2 pb-1 border-b border-slate-200">
                            ${headerText}
                        </h4>
                    `;
                    prerequisiteList.appendChild(sectionHeader);
                }

                // Create grid for this section's subjects
                const buttonGrid = document.createElement('div');
                buttonGrid.className = 'grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4';

                group.subjects.forEach(subject => {
                    const isSelected = existingPrerequisites.includes(subject.subject_code);
                    const sequenceNumber = isSelected ? prerequisiteSequence.indexOf(subject.subject_code) + 2 : 0; // Start from 2 (main subject is 1)
                    const hasPrerequisites = subjectsWithPrerequisites.has(subject.subject_code);
                    const isUsedAsPrerequisite = subjectsUsedAsPrerequisites.has(subject.subject_code);
                    
                    // Disable subjects that:
                    // 1. Already have prerequisites (to prevent circular dependencies)
                    // 2. Are already used as prerequisites for other subjects (to prevent breaking existing chains)
                    const isDisabled = (hasPrerequisites || isUsedAsPrerequisite) && !isSelected;
                    
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.disabled = isDisabled;
                    button.className = `w-full p-3 rounded-lg border-2 text-left transition-all duration-200 ${
                        isDisabled
                            ? 'bg-gray-100 border-gray-200 text-gray-400 cursor-not-allowed opacity-60'
                            : isSelected 
                                ? 'bg-blue-100 border-blue-500 text-blue-800 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500' 
                                : 'bg-white border-gray-300 text-gray-700 hover:border-blue-400 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500'
                    }`;
                    button.dataset.subjectCode = subject.subject_code;
                    button.dataset.selected = isSelected;
                    button.dataset.sequenceNumber = sequenceNumber;
                    button.dataset.hasPrerequisites = hasPrerequisites;
                    button.dataset.isUsedAsPrerequisite = isUsedAsPrerequisite;
                
                    // Get prerequisite codes for this subject
                    const prereqCodes = prerequisiteMap[subject.subject_code] || [];
                    const dependentCodes = dependentMap[subject.subject_code] || [];
                    
                    button.innerHTML = `
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <div class="font-semibold text-sm">${subject.subject_name}</div>
                                    ${prereqCodes.length > 0
                                        ? prereqCodes.map(code => 
                                            `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-300" title="Requires: ${code}">↓ ${code}</span>`
                                          ).join('')
                                        : ''
                                    }
                                    ${dependentCodes.length > 0
                                        ? dependentCodes.map(code => 
                                            `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-700 border border-purple-300" title="Required by: ${code}">↑ ${code}</span>`
                                          ).join('')
                                        : ''
                                    }
                                </div>
                                <div class="text-xs opacity-75">${subject.subject_code}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                ${isSelected 
                                    ? `<div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">${sequenceNumber}</div>`
                                    : isDisabled
                                        ? '<div class="w-6 h-6 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center text-xs font-bold">✕</div>'
                                        : '<div class="w-6 h-6 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-xs font-bold">+</div>'
                                }
                                <div class="flex-shrink-0">
                                    ${isSelected 
                                        ? '<svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>'
                                        : isDisabled
                                            ? '<svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path></svg>'
                                            : '<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>'
                                    }
                                </div>
                            </div>
                        </div>
                    `;
                    
                    // Add click handler for toggle functionality (only if not disabled)
                    if (!isDisabled) {
                        button.addEventListener('click', () => togglePrerequisiteButton(button));
                    }
                    
                    buttonGrid.appendChild(button);
                });

                prerequisiteList.appendChild(buttonGrid);
            });
        }
        
        // Create hidden inputs for form submission
        updateHiddenInputs();
    }

    function togglePrerequisiteButton(button) {
        const isSelected = button.dataset.selected === 'true';
        const subjectCode = button.dataset.subjectCode;
        
        // Toggle selection state
        button.dataset.selected = !isSelected;
        
        // Update sequence tracking
        if (!isSelected) {
            // Add to sequence
            prerequisiteSequence.push(subjectCode);
            const sequenceNumber = prerequisiteSequence.length + 1; // +1 because main subject is #1
            button.dataset.sequenceNumber = sequenceNumber;
            
            // Update button appearance - select
            button.className = button.className.replace(
                'bg-white border-gray-300 text-gray-700 hover:border-blue-400 hover:bg-blue-50',
                'bg-blue-100 border-blue-500 text-blue-800 shadow-md'
            );
            
            // Update the sequence number and icons
            updateButtonContent(button, true, sequenceNumber);
        } else {
            // Remove from sequence and reorder
            const currentSequence = parseInt(button.dataset.sequenceNumber);
            prerequisiteSequence = prerequisiteSequence.filter(code => code !== subjectCode);
            button.dataset.sequenceNumber = 0;
            
            // Update button appearance - deselect
            button.className = button.className.replace(
                'bg-blue-100 border-blue-500 text-blue-800 shadow-md',
                'bg-white border-gray-300 text-gray-700 hover:border-blue-400 hover:bg-blue-50'
            );
            
            // Update this button content
            updateButtonContent(button, false, 0);
            
            // Reorder sequence numbers for remaining selected buttons
            updateAllSequenceNumbers();
        }
        
        // Update hidden inputs for form submission
        updateHiddenInputs();
    }

    function updateButtonContent(button, isSelected, sequenceNumber) {
        const subjectNameDiv = button.querySelector('.font-semibold');
        const subjectName = subjectNameDiv ? subjectNameDiv.textContent : '';
        const subjectCodeDiv = button.querySelector('.text-xs.opacity-75');
        const subjectCode = subjectCodeDiv ? subjectCodeDiv.textContent : '';
        const buttonSubjectCode = button.dataset.subjectCode;
        
        // Get prerequisite and dependent codes for this subject
        const prereqCodes = prerequisiteMap[buttonSubjectCode] || [];
        const dependentCodes = dependentMap[buttonSubjectCode] || [];
        
        button.innerHTML = `
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        <div class="font-semibold text-sm">${subjectName}</div>
                        ${prereqCodes.length > 0
                            ? prereqCodes.map(code => 
                                `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-700 border border-emerald-300" title="Requires: ${code}">↓ ${code}</span>`
                              ).join('')
                            : ''
                        }
                        ${dependentCodes.length > 0
                            ? dependentCodes.map(code => 
                                `<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-700 border border-purple-300" title="Required by: ${code}">↑ ${code}</span>`
                              ).join('')
                            : ''
                        }
                    </div>
                    <div class="text-xs opacity-75">${subjectCode}</div>
                </div>
                <div class="flex items-center gap-2">
                    ${isSelected 
                        ? `<div class="w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold">${sequenceNumber}</div>`
                        : '<div class="w-6 h-6 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center text-xs font-bold">+</div>'
                    }
                    <div class="flex-shrink-0">
                        ${isSelected 
                            ? '<svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>'
                            : '<svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>'
                        }
                    </div>
                </div>
            </div>
        `;
    }

    function updateAllSequenceNumbers() {
        // Update sequence numbers for all selected buttons
        prerequisiteList.querySelectorAll('button[data-selected="true"]').forEach(button => {
            const subjectCode = button.dataset.subjectCode;
            const newSequenceNumber = prerequisiteSequence.indexOf(subjectCode) + 2; // +2 because main subject is #1
            button.dataset.sequenceNumber = newSequenceNumber;
            updateButtonContent(button, true, newSequenceNumber);
        });
    }

    function updateHiddenInputs() {
        // Remove existing hidden inputs
        const existingInputs = prerequisiteForm.querySelectorAll('input[name="prerequisite_codes[]"]');
        existingInputs.forEach(input => input.remove());
        
        // Add hidden inputs for selected prerequisites in sequence order
        prerequisiteSequence.forEach(subjectCode => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'prerequisite_codes[]';
            hiddenInput.value = subjectCode;
            prerequisiteForm.appendChild(hiddenInput);
        });
        
        // Enable/disable save button based on selection
        savePrerequisitesBtn.disabled = !modalSubjectCodeInput.value; // Only require subject selection
    }

    /**
     * Renders the prerequisite chain with complete sequences.
     */
    function renderPrerequisiteChain(prerequisites, subjects, disableSaveButton = true) {
        prerequisiteChainContainer.innerHTML = '';

        const hasPrerequisites = Object.keys(prerequisites).some(key => prerequisites[key].length > 0);

        if (!hasPrerequisites) {
            prerequisiteChainContainer.innerHTML = '<p class="text-center text-gray-500 py-8">No prerequisites have been set for this curriculum yet.</p>';
            savePrerequisiteChainBtn.classList.add('hidden');
            return;
        }

        // Show save button when there are prerequisites
        savePrerequisiteChainBtn.classList.remove('hidden');
        // Only disable save button if explicitly requested (for initial loads)
        if (disableSaveButton) {
            savePrerequisiteChainBtn.disabled = true;
        }

        const subjectMap = new Map(subjects.map(s => [s.subject_code, s]));

        const getSubjectColorClass = (type) => {
            if (!type) return 'subject-tag-default';
            const lowerType = type.toLowerCase();
            const geIdentifiers = ['ge', 'general education', 'general', 'education'];
            if (type.includes('elective')) return 'subject-tag-elective';
            if (geIdentifiers.some(id => type.includes(id))) return 'subject-tag-default';
            return 'subject-tag-default';
        };

        // Build prerequisite maps


        // Find chain starts (subjects with no prerequisites)
        // 1. Build Children Map (Parent -> Array of Children) to identify Leaf/Terminal Nodes
        const childrenMap = {};
        Object.keys(prerequisites).forEach(childCode => {
            prerequisites[childCode].forEach(prereq => {
                const parentCode = prereq.prerequisite_subject_code;
                if (!childrenMap[parentCode]) childrenMap[parentCode] = [];
                childrenMap[parentCode].push(childCode);
            });
        });

        // 2. Identify Terminal Subjects (Subjects that have prerequisites but are NOT prerequisites to others)
        // These are the "Ends" of the chains.
        const subjectsWithPrereqs = Object.keys(prerequisites).filter(key => prerequisites[key].length > 0);
        let terminalSubjects = subjectsWithPrereqs.filter(code => !childrenMap[code]);

        // Fallback: If no terminal subjects found (e.g. cycle or empty), use all subjects with prereqs
        if (terminalSubjects.length === 0 && subjectsWithPrereqs.length > 0) {
             terminalSubjects = subjectsWithPrereqs;
        }

        const uniqueChains = []; 

        // Helper to perform Backward DFS from a node to find all paths to roots
        const buildPaths = (childCode, currentPath) => {
            // Find subject data
            let subject = subjectMap.get(childCode);
            if (!subject) {
                 // Fallback for missing/external subjects
                 subject = {
                    subject_code: childCode,
                    subject_name: childCode, 
                    course_classification: 'External/Unknown',
                    subject_type: 'Unknown'
                };
            }

            const newPath = [subject, ...currentPath];
            
            const parents = prerequisites[childCode];
            
            // If no parents, we reached a root of this chain
            if (!parents || parents.length === 0) {
                // Only add if path has at least 2 nodes (Parent -> Child) or is significant
                if (newPath.length > 1) {
                    // REVERSE the chain for display to match the "Pre-requisite TO" user flow.
                    // Data is stored as: Dependent (Child) -> Prerequisite (Parent).
                    // Logic builds: [Parent, Child].
                    // User wants: [Child (Selected), Parent (Target)].
                    uniqueChains.push([...newPath].reverse());
                }
                return;
            }
            
            // Recurse for each parent
            parents.forEach(p => {
                const parentCode = p.prerequisite_subject_code;
                // Avoid cycles: Check if parent is already in the downstream path
                if (!newPath.some(s => s.subject_code === parentCode)) { 
                    buildPaths(parentCode, newPath);
                }
            });
        };

        // Build all chains starting from terminal nodes
        terminalSubjects.forEach(termCode => buildPaths(termCode, []));

        // 3. Render the Chains
        uniqueChains.forEach(chain => {
             const chainDiv = document.createElement('div');
             chainDiv.className = 'flex items-center justify-between gap-2 p-3 bg-white rounded-lg border border-gray-200 shadow-sm mb-3';
             
             const chainHtml = chain.map((subject, index) => {
                const subjectName = subject.subject_name;
                const subjectCategory = subject.course_classification || 'Uncategorized';
                const subjectColorClass = getSubjectColorClass(subject.subject_type);
                const sequenceNumber = index + 1;
                const isFirst = index === 0;
                
                return `
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 ${isFirst ? 'bg-green-600' : 'bg-blue-600'} text-white rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0 shadow-sm">${sequenceNumber}</div>
                        <div class="flex flex-col">
                            <span class="font-semibold px-3 py-1 rounded-md text-sm border ${subjectColorClass}">${subjectName}</span>
                            <span class="text-xs text-cool-gray-500 mt-0.5 ml-1 italic">${subjectCategory}</span>
                        </div>
                    </div>
                `;
            }).join(' <div class="mx-2 text-gray-300 flex-shrink-0"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></div> ');

            chainDiv.innerHTML = `
                <div class="flex-grow flex flex-wrap items-center gap-2">
                    ${chainHtml}
                </div>
            `;

            prerequisiteChainContainer.appendChild(chainDiv);
        });

        // Edit buttons removed - no longer needed
    }
    
    // Edit button functionality removed

    async function handleSubjectSelection(subjectCode) {
        modalSubjectCodeInput.value = subjectCode;
        savePrerequisitesBtn.disabled = !subjectCode;

        const curriculumId = modalCurriculumIdInput.value;
        if (!subjectCode || !curriculumId) {
            prerequisiteList.innerHTML = '<p class="text-gray-500">Select a curriculum and subject to see available prerequisites.</p>';
            return;
        }
        
        // Don't enable save button just for selecting a subject
        // Save button will be enabled only after successfully saving prerequisites in modal
        
        // Determine correct API endpoint based on ID format
        const virtualIds = [
            'gen-ed-college', 'gen-ed-shs',
            'prof-non-lab', 'prof-lab', 'prof-board', 'prof-non-board', 'prof-oc',
            'research', 'ojt'
        ];
        
        let url = `/api/prerequisites/${curriculumId}`;
        if (virtualIds.includes(curriculumId)) {
            url = `/api/gen-ed-prerequisites/${curriculumId}`;
        }
        
        const response = await fetch(url);
        const data = await response.json();
        const existingPrerequisites = data.prerequisites[subjectCode] ? data.prerequisites[subjectCode].map(p => p.prerequisite_subject_code) : [];
        populatePrerequisiteButtons(subjectCode, existingPrerequisites);
    }

    prerequisiteForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        savePrerequisitesBtn.disabled = true;
        const formData = new FormData(prerequisiteForm);
        
        // Get the "Root" subject (the one selected in the dropdown)
        const rootSubject = formData.get('subject_code');
        const curriculumId = formData.get('curriculum_id');
        
        // We use prerequisiteSequence which stores the values in order of selection [SubjectB, SubjectC, ...]
        // We want to create chain: Root -> SubjectB -> SubjectC ...
        
        // Note: functionality to support MULTIPLE parallel children at the same step is not supported by this linear chain logic.
        // If the user wants parallel structure, they would have to add them separately. 
        // But the current UI with (1)->(2)->(3) strongly implies a linear chain.
        
        let previousSubject = rootSubject;
        
        try {
            // Validate sequence
            if (prerequisiteSequence.length === 0) {
                 throw new Error('No prerequisites selected.');
            }

            // Iterate and create links sequentially
            for (const targetSubject of prerequisiteSequence) {
                const data = {
                    curriculum_id: curriculumId,
                    subject_code: previousSubject, // Parent
                    prerequisite_codes: [targetSubject] // Child
                };
                
                const response = await fetch('/api/prerequisites', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || `Failed to link ${previousSubject} -> ${targetSubject}`);
                }
                
                // Move pointer: current child becomes next parent
                previousSubject = targetSubject;
            }
            
            // All saved successfully
            hideModal();
            
            // Update main page curriculum selection to match modal selection
            const savedCurriculumId = curriculumId;
            const curriculumOption = mainOptionsList.querySelector(`li[data-value="${savedCurriculumId}"]`);
            if (curriculumOption) {
                selectedCurriculum.id = savedCurriculumId;
                selectedCurriculum.name = curriculumOption.dataset.name;
                mainSelectorButton.querySelector('span').textContent = selectedCurriculum.name;
                mainSelectorButton.querySelector('span').classList.remove('text-gray-500');
                // Enable the Set Prerequisite button
                setPrerequisiteBtn.disabled = false;
            }
            
            // Fetch and display the prerequisite chain immediately (without disabling save button)
            await fetchPrerequisiteDataAfterSave(savedCurriculumId);
            
            // Enable save button since new prerequisites were added
            enableSaveButton();
            
            // Show custom success modal
            showPrerequisiteSuccessModal();
        } catch (error) {
            console.error('Error saving prerequisites:', error);
            Swal.fire({
                title: 'Error!',
                text: 'Failed to save prerequisites: ' + error.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } finally {
            savePrerequisitesBtn.disabled = false;
        }
    });

    savePrerequisiteChainBtn.addEventListener('click', () => {
        // Show loading state but don't disable button yet
        document.querySelector('.save-btn-text').classList.add('hidden');
        document.querySelector('.save-btn-loading').classList.remove('hidden');
        
        showConfirmationModal({
            title: 'Save Prerequisite Chain?',
            message: 'Are you sure you want to save the current prerequisite chain configuration?',
            icon: `<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
            confirmButtonClass: 'bg-blue-600 hover:bg-blue-700',
            onConfirm: () => {
                // Now disable the button since user confirmed the save
                savePrerequisiteChainBtn.disabled = true;
                // Show traditional compliance validator modal
                document.getElementById('complianceValidatorModal').classList.remove('hidden');
            }
        });
    });

    const urlParams = new URLSearchParams(window.location.search);
    const curriculumIdFromUrl = urlParams.get('curriculumId');
    if (curriculumIdFromUrl) {
        const optionToSelect = mainOptionsList.querySelector(`li[data-value="${curriculumIdFromUrl}"]`);
        if (optionToSelect) {
            selectedCurriculum.id = curriculumIdFromUrl;
            selectedCurriculum.name = optionToSelect.dataset.name;
            mainSelectorButton.querySelector('span').textContent = selectedCurriculum.name;
            mainSelectorButton.querySelector('span').classList.remove('text-gray-500');
            fetchPrerequisiteData(curriculumIdFromUrl);
            showModal(null, curriculumIdFromUrl);
        }
    }
});
</script>
@endsection