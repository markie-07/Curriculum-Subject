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

                        {{-- NEW: Search Bar and Add Issuance Button --}}
                        <div class="mb-6 flex items-center justify-between gap-4">
                            <input type="text" id="search-bar" placeholder="Search for issuances..." class="flex-1 max-w-lg px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="button" id="add-year-btn" class="ml-auto px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
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
                            <div class="deped-accordion border border-gray-200 rounded-lg" data-year="Shape Paper" data-agency="DepEd">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Shape Paper</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white">
                                    <div class="mb-3 flex justify-end gap-2">
                                        <button type="button" class="add-title-btn px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors flex items-center gap-2" data-year="Shape Paper" data-agency="DepEd">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                            Add Title
                                        </button>
                                        <button type="button" class="add-link-btn px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" data-year="Shape Paper" data-agency="DepEd">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add Link
                                        </button>
                                    </div>
                                    <div class="custom-links-container space-y-2 mb-4" data-year="Shape Paper" data-agency="DepEd"></div>

                                </div>
                            </div>

                            {{-- Accordion for Curriculum Guides (Core) --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg" data-year="Curriculum Guides (Core)" data-agency="DepEd">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Curriculum Guides (Core)</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-2">
                                    <div class="mb-3 flex justify-end gap-2">
                                        <button type="button" class="add-title-btn px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors flex items-center gap-2" data-year="Curriculum Guides (Core)" data-agency="DepEd">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                            Add Title
                                        </button>
                                        <button type="button" class="add-link-btn px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" data-year="Curriculum Guides (Core)" data-agency="DepEd">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add Link
                                        </button>
                                    </div>
                                    <div class="custom-links-container space-y-2 mb-4" data-year="Curriculum Guides (Core)" data-agency="DepEd"></div>

                                </div>
                            </div>

                            {{-- Accordion for Curriculum Guides (Academic) --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg" data-year="Curriculum Guides (Academic)" data-agency="DepEd">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Curriculum Guides (Academic)</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-4">
                                    <!-- Action Buttons -->
                                    <div class="mb-3 flex justify-end gap-2">
                                        <button type="button" class="add-title-btn px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors flex items-center gap-2" data-year="Curriculum Guides (Academic)" data-agency="DepEd">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                            Add Title
                                        </button>
                                        <button type="button" class="add-link-btn px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" data-year="Curriculum Guides (Academic)" data-agency="DepEd">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add Link
                                        </button>
                                    </div>
                                    
                                    <!-- Dynamic Links Container -->
                                    <div class="custom-links-container space-y-2" data-year="Curriculum Guides (Academic)" data-agency="DepEd"></div>

                                </div>
                            </div>

                             {{-- Accordion for Curriculum Guides (TechPro) --}}
                            <div class="deped-accordion border border-gray-200 rounded-lg" data-year="Curriculum Guides (TechPro)" data-agency="DepEd">
                                <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                                    <span class="font-semibold text-gray-700">Curriculum Guides (TechPro)</span>
                                    <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-4">
                                    <div class="mb-3 flex justify-end gap-2">
                                        <button type="button" class="add-title-btn px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors flex items-center gap-2" data-year="Curriculum Guides (TechPro)" data-agency="DepEd">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                                            Add Title
                                        </button>
                                        <button type="button" class="add-link-btn px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" data-year="Curriculum Guides (TechPro)" data-agency="DepEd">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                            Add Link
                                        </button>
                                    </div>
                                    <div class="custom-links-container space-y-2 mb-4" data-year="Curriculum Guides (TechPro)" data-agency="DepEd"></div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Link Modal --}}
    <div id="addLinkModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden opacity-0">
        <div id="add-link-modal-panel" class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <button id="closeAddLinkModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100" aria-label="Close modal">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="text-center mb-6">
                <h2 id="addLinkModalTitle" class="text-2xl font-bold text-slate-800">Add Custom Link</h2>
                <p class="text-sm text-slate-500 mt-1">Add a custom memorandum link</p>
            </div>

            <form id="addLinkForm" class="space-y-4">
                @csrf
                
                {{-- Group Selection (Dynamic) --}}
                <div id="linkGroupContainer" class="hidden">
                    <label for="linkGroup" class="block text-sm font-medium text-slate-700 mb-2">Title / Group (Optional)</label>
                    <div class="relative">
                        <select id="linkGroup" name="group" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                            <option value="">No Group</option>
                            {{-- Options populated by JS --}}
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="linkTitle" class="block text-sm font-medium text-slate-700 mb-2">Link Title</label>
                    <input type="text" id="linkTitle" name="title" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., CMO No. 123, Series of 2024" required>
                </div>

                <div>
                    <label for="linkUrl" class="block text-sm font-medium text-slate-700 mb-2">Link URL</label>
                    <input type="url" id="linkUrl" name="url" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="https://..." required>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" id="cancelAddLinkButton" class="flex-1 px-6 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all">Cancel</button>
                    <button type="submit" class="flex-1 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                        </svg>
                        <span>Save Link</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Add Title (Group) Modal --}}
    <div id="addTitleModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden opacity-0">
        <div id="add-title-modal-panel" class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <button id="closeAddTitleModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100" aria-label="Close modal">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-slate-800">Add Title</h2>
                <p class="text-sm text-slate-500 mt-1">Create a new group title for links</p>
            </div>

            <form id="addTitleForm" class="space-y-4">
                @csrf
                <div>
                    <label for="titleName" class="block text-sm font-medium text-slate-700 mb-2">Title Name</label>
                    <input type="text" id="titleName" name="group" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., SCIENCE, TECHNOLOGY..." required>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" id="cancelAddTitleButton" class="flex-1 px-6 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all">Cancel</button>
                    <button type="submit" class="flex-1 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <span>Create Title</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
 </main>

    {{-- External Link Confirmation Modal --}}
    <div id="externalLinkModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden opacity-0">
        <div id="external-link-modal-panel" class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <button id="closeExternalLinkModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100" aria-label="Close modal">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="w-12 h-12 rounded-full bg-blue-100 p-2 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
            </div>
            
            <h3 class="text-lg font-semibold text-slate-800">Open External Link?</h3>
            <p class="text-sm text-slate-500 mt-2">You are about to open:</p>
            <p id="document-title" class="text-sm font-medium text-slate-700 mt-1"></p>
            
            <div class="mt-6 flex justify-center gap-4">
                <button id="cancelExternalLinkButton" class="px-6 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all">Cancel</button>
                <button id="confirmExternalLinkButton" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all">Open Link</button>
            </div>
        </div>
    </div>

    {{-- Add New Year Modal --}}
    <div id="addYearModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden opacity-0">
        <div id="add-year-modal-panel" class="relative bg-white w-full max-w-lg rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out">
            <button id="closeAddYearModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100" aria-label="Close modal">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-slate-800">Add New Issuance</h2>
                <p class="text-sm text-slate-500 mt-1">Create a new category for CHED or DepEd issuances</p>
            </div>

            <form id="addYearForm" class="space-y-4">
                @csrf
                <div>
                    <label for="newYear" class="block text-sm font-medium text-slate-700 mb-2">Issuance Name</label>
                    <input type="text" id="newYear" name="year" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., 2026 CHED Memorandum Orders" required>
                    <p class="text-xs text-slate-500 mt-1">Enter the complete name as you want it to appear</p>
                </div>

                <div>
                    <label for="newYearAgency" class="block text-sm font-medium text-slate-700 mb-2">Agency</label>
                    <select id="newYearAgency" name="agency" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <option value="">Select Agency</option>
                        <option value="CHED">CHED</option>
                        <option value="DepEd">DepEd</option>
                    </select>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="button" id="cancelAddYearButton" class="flex-1 px-6 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all">Cancel</button>
                    <button type="submit" class="flex-1 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <span>Create</span>
                    </button>
                </div>
            </form>
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
    const addYearBtn = document.getElementById('add-year-btn');
    
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

    // Add Year Modal elements
    const addYearModal = document.getElementById('addYearModal');
    const addYearModalPanel = document.getElementById('add-year-modal-panel');
    const closeAddYearModalButton = document.getElementById('closeAddYearModalButton');
    const cancelAddYearButton = document.getElementById('cancelAddYearButton');
    const addYearForm = document.getElementById('addYearForm');
    const newYearInput = document.getElementById('newYear');
    const newYearAgencySelect = document.getElementById('newYearAgency');

    // Debug: Check which elements are missing
    console.log('Modal elements check:', {
        externalLinkModal: !!externalLinkModal,
        addLinkModal: !!addLinkModal,
        addYearModal: !!addYearModal,
        closeExternalLinkModalButton: !!closeExternalLinkModalButton,
        closeAddLinkModalButton: !!closeAddLinkModalButton,
        closeAddYearModalButton: !!closeAddYearModalButton,
        cancelExternalLinkButton: !!cancelExternalLinkButton,
        cancelAddLinkButton: !!cancelAddLinkButton,
        cancelAddYearButton: !!cancelAddYearButton,
        confirmExternalLinkButton: !!confirmExternalLinkButton,
        addLinkForm: !!addLinkForm,
        addYearForm: !!addYearForm
    });

    let currentLink = null;
    let currentYear = null;
    let currentAgency = null;
    let editingLinkId = null;
    let isLoadingAll = false;

    window.agencyLinks = {};

    // --- Data Management ---
    const fetchAllLinksForAgency = async (agency) => {
        try {
            const response = await fetch(`${API_BASE_URL}?agency=${agency}`);
            const data = await response.json();
            const links = Array.isArray(data) ? data : [];
            window.agencyLinks[agency] = links;
            return links;
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
        
        // Group by 'group' field
        const linksByGroup = links.reduce((acc, link) => {
            const groupName = link.group || 'Untitled';
            if (!acc[groupName]) acc[groupName] = [];
            acc[groupName].push(link);
            return acc;
        }, {});
        
        // Separate 'Untitled' (no group) from named groups
        const untitledLinks = linksByGroup['Untitled'] || [];
        delete linksByGroup['Untitled'];
        
        // Render Named Groups first
        Object.keys(linksByGroup).sort().forEach(groupName => {
            const groupLinks = linksByGroup[groupName];
            
            // Find if there's a placeholder record (defined title)
            const placeholder = groupLinks.find(l => !l.title && !l.url);
            const placeholderId = placeholder ? placeholder.id : null;

            const groupDiv = document.createElement('div');
            groupDiv.className = 'group-container space-y-2 mb-4';
            
            // Header
            const header = document.createElement('h4');
            header.className = 'font-bold text-gray-600 pl-1 flex items-center gap-2';
            
            const titleSpan = document.createElement('span');
            titleSpan.textContent = groupName;
            header.appendChild(titleSpan);



            groupDiv.appendChild(header);
            
            // Render links in this group
            groupLinks.forEach(link => {
                if (!link.title || !link.url) return; // Skip the placeholder itself
                const linkDiv = createLinkItem(link);
                groupDiv.appendChild(linkDiv);
            });
            
            container.appendChild(groupDiv);
        });
        
        // Render Ungrouped Links
        if (untitledLinks.length > 0) {
            const ungroupedDiv = document.createElement('div');
            ungroupedDiv.className = 'space-y-2 pt-2';
            untitledLinks.forEach(link => {
                // If it's a placeholder group header (title/url null) but ended up here, skip
                if (!link.title && !link.url) {
                    // This creates a header for a group that somehow lost its name or is untitled but is a placeholder?
                    // Should be rare, but handle it:
                     const header = document.createElement('h4');
                     header.className = 'font-bold text-gray-400 pl-1 mt-2 text-sm italic';
                     header.textContent = link.group || 'Untitled Group';

                     
                     container.appendChild(header);
                    return;
                }
                
                const linkDiv = createLinkItem(link);
                ungroupedDiv.appendChild(linkDiv);
            });
            container.appendChild(ungroupedDiv);
        }
        
        container.dataset.loaded = 'true';
    };

    const createLinkItem = (link) => {

        const linkDiv = document.createElement('div');
        linkDiv.className = 'custom-link-item flex items-center gap-2 p-2 rounded-md hover:bg-blue-50 transition-colors duration-200';
        linkDiv.innerHTML = `
            <a href="${link.url}" target="_blank" class="flex-grow text-blue-600 hover:underline text-sm md:text-base pl-2 border-l-2 border-transparent hover:border-blue-400 h-full flex items-center">${link.title}</a>
        `;
        return linkDiv;
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
    
    // Expose delete function globally so onclick works (Must be after definition)
    window.deleteCustomLink = deleteCustomLink;

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
        
        // Populate Group Select
        const groupSelect = document.getElementById('linkGroup');
        const groupContainer = document.getElementById('linkGroupContainer');
        groupSelect.innerHTML = '<option value="">No Group</option>';

        if (agency === 'DepEd') {
            groupContainer.classList.remove('hidden');
            
            // Hardcoded Standard Groups for DepEd
            const standardGroups = {
                'Curriculum Guides (Academic)': [
                    'ARTS, SOCIAL SCIENCE, AND HUMANITIES',
                    'BUSINESS AND ENTREPRENEURSHIP',
                    'SCIENCE, TECHNOLOGY, ENGINEERING, AND MATHEMATICS',
                    'SPORTS, HEALTH, AND WELLNESS'
                ],
                'Curriculum Guides (TechPro)': [
                    'INFORMATION AND COMMUNICATIONS TECHNOLOGY',
                    'HOME ECONOMICS',
                    'INDUSTRIAL ARTS',
                    'AGRI-FISHERY ARTS'
                ]
            };

            // Find existing groups for this year (from DB)
            const allLinks = window.agencyLinks[agency] || [];
            const yearLinks = allLinks.filter(l => l.year === year);
            const dynamicGroups = [...new Set(yearLinks.map(l => l.group).filter(g => g))];
            
            // Combine with standard groups if applicable
            let allGroups = [...dynamicGroups];
            if (standardGroups[year]) {
                allGroups = [...new Set([...allGroups, ...standardGroups[year]])];
            }
            
            allGroups.sort().forEach(g => {
                const opt = document.createElement('option');
                opt.value = g;
                opt.textContent = g;
                groupSelect.appendChild(opt);
            });
        } else {
            groupContainer.classList.add('hidden');
        }

        if (existingLink) {
            editingLinkId = existingLink.id;
            addLinkModalTitle.textContent = 'Edit Custom Link';
            linkTitleInput.value = existingLink.title;
            linkUrlInput.value = existingLink.url;
            if (existingLink.group) groupSelect.value = existingLink.group;
        } else {
            editingLinkId = null;
            addLinkModalTitle.textContent = 'Add Custom Link';
            linkTitleInput.value = '';
            linkUrlInput.value = '';
            groupSelect.value = '';
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
    
    // Add Title Modal Logic
    const addTitleModal = document.getElementById('addTitleModal');
    const addTitleModalPanel = document.getElementById('add-title-modal-panel');
    const addTitleForm = document.getElementById('addTitleForm');
    const titleNameInput = document.getElementById('titleName');
    const closeAddTitleModalButton = document.getElementById('closeAddTitleModalButton');
    const cancelAddTitleButton = document.getElementById('cancelAddTitleButton');



    const showAddTitleModal = (year, agency) => {
        currentYear = year;
        currentAgency = agency;
        titleNameInput.value = '';
        
        addTitleModal.classList.remove('hidden');
        setTimeout(() => {
            addTitleModal.classList.remove('opacity-0');
            addTitleModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hideAddTitleModal = () => {
        addTitleModal.classList.add('opacity-0');
        addTitleModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            addTitleModal.classList.add('hidden');
            addTitleForm.reset();
        }, 300);
    };

    // Add Title Modal Event Listeners (Must be after hideAddTitleModal is defined)
    if (closeAddTitleModalButton) closeAddTitleModalButton.addEventListener('click', hideAddTitleModal);
    if (cancelAddTitleButton) cancelAddTitleButton.addEventListener('click', hideAddTitleModal);
    if (addTitleModal) {
        addTitleModal.addEventListener('click', (e) => {
            if (e.target === addTitleModal) hideAddTitleModal();
        });
    }

    const showAddYearModal = () => {
        const currentAgency = selectedAgencySpan.textContent.trim();
        if (currentAgency && currentAgency !== 'Select Agency') {
            newYearAgencySelect.value = currentAgency;
        }
        
        addYearModal.classList.remove('hidden');
        setTimeout(() => {
            addYearModal.classList.remove('opacity-0');
            addYearModalPanel.classList.remove('opacity-0', 'scale-95');
        }, 10);
    };

    const hideAddYearModal = () => {
        addYearModal.classList.add('opacity-0');
        addYearModalPanel.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            addYearModal.classList.add('hidden');
            addYearForm.reset();
        }, 300);
    };

    const createYearAccordion = async (year, agency, skipSave = false) => {
        const container = agency === 'CHED' ? document.getElementById('ched-links') : document.getElementById('deped-links');
        if (!container) return;

        // Check if year/category already exists
        const existingAccordion = container.querySelector(`[data-year="${year}"]`);
        if (existingAccordion) {
            if (!skipSave) {
                alert(`This ${agency} issuance already exists!`);
            }
            return;
        }

        const accordionDiv = document.createElement('div');
        accordionDiv.className = `${agency.toLowerCase()}-accordion border border-gray-200 rounded-lg`;
        accordionDiv.dataset.year = year;
        
        accordionDiv.innerHTML = `
            <button type="button" class="accordion-header w-full flex justify-between items-center p-4 bg-white hover:bg-gray-100 transition">
                <span class="font-semibold text-gray-700">${year}</span>
                <svg class="w-5 h-5 text-gray-500 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <div class="accordion-content hidden p-4 border-t border-gray-200 bg-white space-y-2">
                <!-- Action Buttons -->
                <div class="mb-3 flex justify-end gap-2">
                    ${agency === 'DepEd' ? `
                    <button type="button" class="add-title-btn px-3 py-2 bg-slate-100 text-slate-700 text-sm font-medium rounded-lg hover:bg-slate-200 transition-colors flex items-center gap-2" data-year="${year}" data-agency="${agency}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        Add Title
                    </button>
                    ` : ''}
                    <button type="button" class="add-link-btn px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2" data-year="${year}" data-agency="${agency}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Link
                    </button>
                </div>
                
                <!-- Custom Links Container -->
                <div class="custom-links-container space-y-2" data-year="${year}" data-agency="${agency}"></div>
                
                <!-- Fallback Link -->
                ${agency === 'CHED' ? `<a href="https://ched.gov.ph/${year}-ched-memorandum-orders/" target="_blank" class="block text-blue-600 hover:underline p-2 rounded-md hover:bg-blue-50">View all ${year} issuances on the CHED website</a>` : ''}
            </div>
        `;

        // Insert at the top of the container
        container.insertBefore(accordionDiv, container.firstChild);

        // Add accordion click handler
        const header = accordionDiv.querySelector('.accordion-header');
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const icon = header.querySelector('svg');
            const isOpening = content.classList.contains('hidden');
            
            content.classList.toggle('hidden', !isOpening);
            icon.classList.toggle('rotate-180', isOpening);
        });

        // Save to database if not skipping (i.e., user-created, not loaded from DB)
        if (!skipSave) {
            try {
                console.log('Saving category to database:', { agency, year });
                const response = await fetch(`${API_BASE_URL}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        agency: agency,
                        year: year,
                        is_category: true,
                        title: null,
                        url: null
                    })
                });

                const result = await response.json();
                
                if (!response.ok) {
                    console.error('Failed to save category to database:', result);
                    alert('Failed to save category. Please try again.');
                } else {
                    console.log('Category saved successfully:', result);
                }
            } catch (error) {
                console.error('Error saving category:', error);
                alert('Error saving category: ' + error.message);
            }
        }
    };

    const loadCategories = async (agency) => {
        try {
            console.log('Loading categories for agency:', agency);
            const response = await fetch(`${API_BASE_URL}/categories?agency=${agency}`);
            const categories = await response.json();
            
            console.log('Loaded categories:', categories);
            
            categories.forEach(category => {
                createYearAccordion(category.year, category.agency, true); // skipSave = true
            });
        } catch (error) {
            console.error('Error loading categories:', error);
        }
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

            // Load categories first
            if (!targetSection.dataset.categoriesLoaded) {
                await loadCategories(agency);
                targetSection.dataset.categoriesLoaded = 'true';
            }

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
    agencyButton.addEventListener('click', (e) => {
        e.stopPropagation(); // Stop propagation to prevent immediate close by window listener
        const isHidden = agencyMenu.classList.contains('hidden');
        agencyMenu.classList.toggle('hidden');
        agencyButton.setAttribute('aria-expanded', !isHidden);
    });

    // Close dropdown when clicking outside
    window.addEventListener('click', (e) => {
        if (!agencyButton.contains(e.target) && !agencyMenu.contains(e.target)) {
            agencyMenu.classList.add('hidden');
            agencyButton.setAttribute('aria-expanded', 'false');
        }
    });

    // Modal close events (with null checks)
    if (closeExternalLinkModalButton) {
        closeExternalLinkModalButton.addEventListener('click', hideExternalLinkModal);
    }
    if (cancelExternalLinkButton) {
        cancelExternalLinkButton.addEventListener('click', hideExternalLinkModal);
    }
    if (confirmExternalLinkButton) {
        confirmExternalLinkButton.addEventListener('click', () => {
            if (currentLink) {
                window.open(currentLink, '_blank');
                hideExternalLinkModal();
            }
        });
    }

    if (externalLinkModal) {
        externalLinkModal.addEventListener('click', (e) => {
            if (e.target === externalLinkModal) hideExternalLinkModal();
        });
    }

    if (closeAddLinkModalButton) {
        closeAddLinkModalButton.addEventListener('click', hideAddLinkModal);
    }
    if (cancelAddLinkButton) {
        cancelAddLinkButton.addEventListener('click', hideAddLinkModal);
    }
    if (addLinkModal) {
        addLinkModal.addEventListener('click', (e) => {
            if (e.target === addLinkModal) hideAddLinkModal();
        });
    }

    // Add Year Modal events
    if (addYearBtn) {
        addYearBtn.addEventListener('click', () => {
            const currentAgency = selectedAgencySpan.textContent.trim();
            if (currentAgency === 'Select Agency') {
                alert('Please select an agency first (CHED or DepEd)');
                return;
            }
            showAddYearModal();
        });
    }

    if (closeAddYearModalButton) {
        closeAddYearModalButton.addEventListener('click', hideAddYearModal);
    }
    if (cancelAddYearButton) {
        cancelAddYearButton.addEventListener('click', hideAddYearModal);
    }
    if (addYearModal) {
        addYearModal.addEventListener('click', (e) => {
            if (e.target === addYearModal) hideAddYearModal();
        });
    }

    // Add Year Form Submit
    if (addYearForm) {
        addYearForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const year = newYearInput.value.trim();
            const agency = newYearAgencySelect.value;
            
            if (!year || !agency) {
                alert('Please fill in all fields');
                return;
            }

            createYearAccordion(year, agency);
            hideAddYearModal();
        });
    }

    // Action Buttons Delegation (Add Link & Add Title)
    document.addEventListener('click', (e) => {
        const linkBtn = e.target.closest('.add-link-btn');
        if (linkBtn) {
            e.stopPropagation();
            showAddLinkModal(linkBtn.dataset.year, linkBtn.dataset.agency);
            return;
        }

        const titleBtn = e.target.closest('.add-title-btn');
        if (titleBtn) {
            e.stopPropagation();
            showAddTitleModal(titleBtn.dataset.year, titleBtn.dataset.agency);
            return;
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

    // Add Title Form Submit
    if (addTitleForm) {
        addTitleForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const group = titleNameInput.value.trim();
            if (!group) return;

            const payload = {
                agency: currentAgency,
                year: currentYear,
                group: group,
                title: null, 
                url: null,
                is_category: false
            };

            try {
                const response = await fetch(API_BASE_URL, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    hideAddTitleModal();
                    const links = await fetchAllLinksForAgency(currentAgency);
                    distributeLinks(links, currentAgency);
                } else {
                    alert('Failed to add title');
                }
            } catch (error) {
                console.error('Error adding title:', error);
            }
        });
    }

    // Add Link Form Submit
    addLinkForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const title = linkTitleInput.value.trim();
        const url = linkUrlInput.value.trim();
        const groupSelect = document.getElementById('linkGroup');
        const group = groupSelect ? groupSelect.value : null;

        if (!title || !url) return;

        const data = { 
            agency: currentAgency, 
            year: currentYear, 
            title, 
            url,
            group: group || null,
            is_category: false
        };

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