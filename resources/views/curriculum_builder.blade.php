@extends('layouts.app')

@section('content')
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50 p-4 sm:p-6 md:p-8">
        <div>
            
            {{-- Main Header with New Icon --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
                <div class="flex items-start gap-4">
                    {{-- Icon for Curriculum Builder --}}
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <div class="flex-grow flex flex-col sm:flex-row justify-between items-start sm:items-center">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Curriculum Builder</h1>
                            <p class="text-sm text-slate-500 mt-1">Design and manage your academic curriculums.</p>
                        </div>
                        <button id="addCurriculumButton" class="w-full mt-4 sm:mt-0 sm:w-auto flex items-center justify-center space-x-2 px-5 py-2.5 bg-blue-600 text-white border-2 border-blue-600 rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-200 shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            <span>Add Curriculum</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Curriculums Section --}}
            <div class="bg-white p-4 sm:p-6 md:p-8 rounded-2xl shadow-sm border border-slate-200">
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
                    <h2 class="text-xl font-bold text-slate-700">Existing Curriculums</h2>
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        {{-- Version Filter --}}
                        <div class="relative w-full sm:w-48">
                            <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.628 1.601C5.028 1.206 7.49 1 10 1s4.973.206 7.372.601a.75.75 0 01.628.74v2.288a2.25 2.25 0 01-.659 1.59l-4.682 4.683a2.25 2.25 0 00-.659 1.59v3.037c0 .684-.31 1.33-.844 1.757l-1.937 1.55A.75.75 0 018 18.25v-5.757a2.25 2.25 0 00-.659-1.591L2.659 6.22A2.25 2.25 0 012 4.629V2.34a.75.75 0 01.628-.74z" clip-rule="evenodd" />
                            </svg>
                            <select id="version-filter" class="w-full appearance-none pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                <option value="new" selected>New</option>
                                <option value="old">Old</option>
                            </select>
                            <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                        </div>
                        {{-- Approval Status Filter --}}
                        <div class="relative w-full sm:w-48">
                            <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                            </svg>
                            <select id="approval-filter" class="w-full appearance-none pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                <option value="all" selected>All Status</option>
                                <option value="processing">Processing</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                        </div>
                        {{-- Search Bar --}}
                        <div class="relative w-full sm:w-72">
                            <svg class="w-5 h-5 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                            </svg>
                            <input type="text" id="search-bar" placeholder="Search..." class="w-full pl-10 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-10">
                    <div>
                        <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-200">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span>Senior High</span>
                        </h3>
                        <div id="senior-high-curriculums" class="space-y-4 pt-2">
                            <p class="text-slate-500 text-sm py-4">No Senior High curriculums found.</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="flex items-center gap-3 text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-200">
                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                               <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222 4 2.222V20M1 12v7a2 2 0 002 2h18a2 2 0 002-2v-7" />
                            </svg>
                           <span>College</span>
                        </h3>
                        <div id="college-curriculums" class="space-y-4 pt-2">
                           <p class="text-slate-500 text-sm py-4">No College curriculums found.</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal for adding/editing a curriculum --}}
            <div id="addCurriculumModal" class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div class="relative bg-white w-full max-w-3xl rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out" id="modal-panel">
                        <button id="closeModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100" aria-label="Close modal">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        
                        <div class="text-center mb-8">
                            <img src="{{ asset('/images/SMSIII LOGO.png') }}" alt="SMS3 Logo" class="mx-auto h-16 w-auto mb-4">
                            <h2 id="modal-title" class="text-2xl font-bold text-slate-800">Create New Curriculum</h2>
                            <p class="text-sm text-slate-500 mt-1">Fill in the details below to add a new curriculum.</p>
                        </div>

                        <form id="curriculumForm" class="space-y-6">
                            @csrf
                            <input type="hidden" id="curriculumId" name="curriculumId">
                            
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label for="curriculum" class="block text-sm font-medium text-slate-700">Curriculum Name</label>
                                </div>
                                <div class="flex gap-2">
                                    <div class="relative w-full">
                                        {{-- Hidden select for form submission --}}
                                        <select id="curriculum" name="curriculum" class="hidden" required>
                                            <option value="" disabled selected>Select Curriculum</option>
                                            @if(isset($programs))
                                                <optgroup label="College">
                                                    @foreach($programs->where('department', 'College') as $program)
                                                        <option value="{{ $program->description }}" data-code="{{ $program->code }}">{{ $program->description }}</option>
                                                    @endforeach
                                                </optgroup>
                                                <optgroup label="Senior High">
                                                    @foreach($programs->where('department', 'Senior High') as $program)
                                                        <option value="{{ $program->description }}" data-code="{{ $program->code }}">{{ $program->description }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        </select>

                                        {{-- Custom searchable dropdown --}}
                                        <div class="relative">
                                            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none z-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                                            <button type="button" id="curriculumDropdownButton" class="w-full appearance-none pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-left text-slate-500">
                                                <span id="curriculumSelectedText">Select Curriculum</span>
                                            </button>
                                            <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none transition-transform" id="curriculumDropdownArrow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                                            
                                            {{-- Dropdown menu --}}
                                            <div id="curriculumDropdownMenu" class="hidden absolute z-50 w-full mt-2 bg-white border border-slate-300 rounded-lg shadow-lg max-h-80 overflow-hidden">
                                                {{-- Search input --}}
                                                <div class="p-3 border-b border-slate-200 bg-slate-50">
                                                    <div class="relative">
                                                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                                                        <input type="text" id="curriculumSearchInput" placeholder="Search curriculum..." class="w-full pl-9 pr-3 py-2 text-sm border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                    </div>
                                                </div>
                                                
                                                {{-- Options list --}}
                                                <div id="curriculumOptionsList" class="overflow-y-auto max-h-60">
                                                    @if(isset($programs))
                                                        <div class="curriculum-group">
                                                            <div class="px-3 py-2 text-xs font-semibold text-slate-500 bg-slate-50 sticky top-0">College</div>
                                                            @foreach($programs->where('department', 'College') as $program)
                                                                <div class="curriculum-option px-3 py-2 hover:bg-blue-50 cursor-pointer transition-colors" data-value="{{ $program->description }}" data-code="{{ $program->code }}" data-department="College">
                                                                    <div class="text-sm text-slate-700">{{ $program->description }}</div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="curriculum-group">
                                                            <div class="px-3 py-2 text-xs font-semibold text-slate-500 bg-slate-50 sticky top-0">Senior High</div>
                                                            @foreach($programs->where('department', 'Senior High') as $program)
                                                                <div class="curriculum-option px-3 py-2 hover:bg-blue-50 cursor-pointer transition-colors" data-value="{{ $program->description }}" data-code="{{ $program->code }}" data-department="Senior High">
                                                                    <div class="text-sm text-slate-700">{{ $program->description }}</div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="addNewProgramButton" class="flex-shrink-0 px-3 py-2 bg-blue-100 text-blue-600 rounded-lg border border-blue-200 hover:bg-blue-200 transition-colors" title="Add New Curriculum Name">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                
                                {{-- Duplicate Detection Alert --}}
                                <div id="duplicateAlert" class="hidden mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                    <div class="flex items-start gap-2 mb-2">
                                        <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                        </svg>
                                        <div class="flex-grow">
                                            <p class="text-sm font-medium text-amber-800">A curriculum with this name already exists</p>
                                            <div id="duplicateList" class="mt-2 space-y-1 text-xs text-amber-700">
                                                {{-- Matching curriculums will be listed here --}}
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Buttons removed as per user request --}}
                                </div>
                                
                                {{-- Browse Curriculums Dropdown --}}
                                <div id="browseCurriculumsDropdown" class="hidden absolute z-10 mt-1 w-full bg-white rounded-lg shadow-lg border border-slate-200 max-h-80 overflow-y-auto">
                                    <div class="p-2 border-b border-slate-200 sticky top-0 bg-white">
                                        <input type="text" id="browseSearchInput" placeholder="Search curriculums..." class="w-full px-3 py-2 text-sm border border-slate-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div id="browseCurriculumsList" class="p-2">
                                        {{-- Curriculum list will be populated here --}}
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label for="programCode" class="block text-sm font-medium text-slate-700 mb-1">Program Code <span class="text-xs text-slate-500">(Auto-filled)</span></label>
                                <div class="relative">
                                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.5A.75.75 0 014.5 3h15a.75.75 0 01.75.75v15a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75v-15zM8.25 9a.75.75 0 000 1.5h7.5a.75.75 0 000-1.5h-7.5zM8.25 12.75a.75.75 0 000 1.5h4.5a.75.75 0 000-1.5h-4.5z" /></svg>
                                    <input type="text" id="programCode" name="programCode" placeholder="Select a curriculum first" class="w-full pl-10 pr-4 py-2.5 bg-gray-100 text-slate-600 border border-slate-300 rounded-lg shadow-sm cursor-not-allowed" required readonly>
                                </div>
                            </div>
                            <div>
                                <label for="yearLevel" class="block text-sm font-medium text-slate-700 mb-1">Level <span class="text-xs text-slate-500">(Auto-filled)</span></label>
                                 <div class="relative">
                                     <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5-1.5V3" /></svg>
                                    <select id="yearLevel" name="yearLevel" class="w-full appearance-none pl-10 pr-10 py-2.5 bg-gray-100 text-slate-600 border border-slate-300 rounded-lg shadow-sm cursor-not-allowed pointer-events-none" required tabindex="-1">
                                        <option value="" disabled selected>Select a curriculum first</option>
                                        <option value="Senior High">Senior High</option>
                                        <option value="College">College</option>
                                    </select>
                                    <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                                </div>
                            </div>
                            <div id="academicYearContainer">
                                <label for="academicYear" class="block text-sm font-medium text-slate-700 mb-1">Academic Year</label>
                                <div class="relative">
                                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M12 12.75h.008v.008H12v-.008z" /></svg>
                                    <input type="text" id="academicYear" name="academicYear" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                                </div>
                            </div>
                            <div id="expirationDateContainer">
                                <label for="expirationDate" class="block text-sm font-medium text-slate-700 mb-1">Curriculum Expiration Date</label>
                                <div class="relative">
                                    <div class="relative group">
                                        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none z-10 transition-colors group-focus-within:text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M12 12.75h.008v.008H12v-.008z" /></svg>
                                        <input type="text" id="expirationDateDisplay" readonly placeholder="Select a date" class="cursor-pointer w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-slate-400">
                                        <input type="hidden" id="expirationDate" name="expirationDate">
                                        <button type="button" id="clearExpirationDate" class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-red-500 transition-colors z-10" title="Clear date">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    
                                    <!-- Custom Calendar Picker -->
                                    <div id="customCalendar" class="hidden absolute top-full left-0 mt-2 bg-white rounded-xl shadow-2xl border border-slate-200 p-4 w-80 z-50">
                                        <!-- Calendar Header -->
                                        <div class="flex items-center justify-between mb-4">
                                            <button type="button" id="prevMonth" class="p-1.5 hover:bg-slate-100 rounded-lg transition-colors">
                                                <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                                </svg>
                                            </button>
                                            <button type="button" id="monthYearToggle" class="flex items-center gap-1 px-3 py-1.5 hover:bg-slate-100 rounded-lg transition-colors">
                                                <span class="font-semibold text-slate-800" id="currentMonthYear"></span>
                                                <svg class="w-4 h-4 text-slate-500 transition-transform" id="toggleArrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                            <button type="button" id="nextMonth" class="p-1.5 hover:bg-slate-100 rounded-lg transition-colors">
                                                <svg class="w-5 h-5 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Month View -->
                                        <div id="monthView">
                                            <!-- Days of Week -->
                                            <div class="grid grid-cols-7 gap-1 mb-2">
                                                <div class="text-center text-xs font-medium text-slate-500 py-2">Su</div>
                                                <div class="text-center text-xs font-medium text-slate-500 py-2">Mo</div>
                                                <div class="text-center text-xs font-medium text-slate-500 py-2">Tu</div>
                                                <div class="text-center text-xs font-medium text-slate-500 py-2">We</div>
                                                <div class="text-center text-xs font-medium text-slate-500 py-2">Th</div>
                                                <div class="text-center text-xs font-medium text-slate-500 py-2">Fr</div>
                                                <div class="text-center text-xs font-medium text-slate-500 py-2">Sa</div>
                                            </div>
                                            
                                            <!-- Calendar Days Grid -->
                                            <div id="calendarDays" class="grid grid-cols-7 gap-1 mb-3"></div>
                                        </div>
                                        
                                        <!-- Year Picker View -->
                                        <div id="yearView" class="hidden">
                                            <div class="grid grid-cols-4 gap-2 mb-3" id="yearGrid"></div>
                                        </div>
                                        
                                        <!-- Action Buttons -->
                                        <div class="flex items-center justify-between pt-3 border-t border-slate-200">
                                            <button type="button" id="clearDateBtn" class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">Clear</button>
                                            <button type="button" id="todayBtn" class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-colors">Today</button>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">When this date is reached, the curriculum will automatically become "old" and you'll need to create a new one.</p>
                            </div>

                            
                            <div>
                                <label for="compliance" class="block text-sm font-medium text-slate-700 mb-1">Choose Compliance</label>
                                <div class="relative">
                                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c0 .621-.504 1.125-1.125 1.125H18a2.25 2.25 0 01-2.25-2.25M6.75 17.25h-.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V4.875c0-.621.504-1.125 1.125-1.125H6.75a1.125 1.125 0 011.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125z" /></svg>
                                    <select id="compliance" name="compliance" class="w-full appearance-none pl-10 pr-4 py-2.5 bg-gray-100 text-slate-500 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors pointer-events-none" required>
                                        <option value="" disabled selected>Select Compliance</option>
                                        <option value="CHED">CHED</option>
                                        <option value="DepEd">DepEd</option>
                                    </select>
                                    <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                                </div>
                            </div>
                            
                            <div id="memorandumContainer" class="hidden">
                <!-- Year Selection for CHED (hidden by default) -->
                <div id="yearContainer" class="hidden mb-4">
                    <label for="memorandumYear" class="block text-sm font-medium text-slate-700 mb-1">Memorandum Year</label>
                    <div class="relative">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M12 12.75h.008v.008H12v-.008z" /></svg>
                        <select id="memorandumYear" name="memorandumYear" class="w-full appearance-none pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled selected>Select Year</option>
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                            <option value="2019">2019</option>
                            <option value="2018">2018</option>
                            <option value="2017">2017</option>
                            <option value="2016">2016</option>
                        </select>
                        <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
                
                <!-- Category Selection for DepEd (hidden by default) -->
                <div id="categoryContainer" class="hidden mb-4">
                    <label for="memorandumCategory" class="block text-sm font-medium text-slate-700 mb-1">Document Category</label>
                    <div class="relative">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25H11.182c-.397 0-.779-.158-1.06-.44z" /></svg>
                        <select id="memorandumCategory" name="memorandumCategory" class="w-full appearance-none pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <option value="" disabled selected>Select Category</option>
                            <option value="Shape Paper">Shape Paper</option>
                            <option value="Curriculum Guides (Core)">Curriculum Guides (Core)</option>
                            <option value="Curriculum Guides (Academic)">Curriculum Guides (Academic)</option>
                            <option value="Curriculum Guides (TechPro)">Curriculum Guides (TechPro)</option>
                        </select>
                        <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                    </div>
                </div>
                
                <label for="memorandum" class="block text-sm font-medium text-slate-700 mb-1">Official Memorandum</label>
                <div class="relative">
                    <svg class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c0 .621-.504 1.125-1.125 1.125H11.25a9 9 0 00-9-9V3.375c0-.621.504-1.125 1.125-1.125z" /></svg>
                    <select id="memorandum" name="memorandum" class="w-full appearance-none pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        <option value="" disabled selected>Select Memorandum</option>
                    </select>
                    <svg class="w-5 h-5 text-slate-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 011.06 0L10 11.94l3.72-3.72a.75.75 0 111.06 1.06l-4.25 4.25a.75.75 0 01-1.06 0L5.22 9.28a.75.75 0 010-1.06z" clip-rule="evenodd" /></svg>
                </div>
                
                {{-- Duplicate Memorandum Warning --}}
                <div id="duplicateMemorandumAlert" class="hidden mt-2 p-2 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-xs font-medium text-red-800">This memorandum is already used for this curriculum name. You may be creating a duplicate!</p>
                    </div>
                </div>
            </div>
                            
                            <div id="unitsContainer" class="hidden">
                                <label id="semesterUnitsLabel" class="block text-sm font-medium text-slate-700 mb-3">Semester Units</label>
                                <div id="semesterInputs" class="space-y-3">
                                    <!-- Dynamic semester inputs will be inserted here -->
                                </div>
                                <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-blue-800">Total Units:</span>
                                        <span id="totalUnits" class="text-lg font-bold text-blue-900">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-6 flex flex-col sm:flex-row-reverse gap-3">
                                <button type="submit" id="submit-button" class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-3 rounded-lg text-sm font-semibold text-white bg-blue-600 border-2 border-blue-600 hover:bg-white hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" /></svg>
                                    <span>Create</span>
                                </button>
                                <button type="button" id="cancelModalButton" class="w-full sm:w-auto px-6 py-3 border-2 border-slate-500 rounded-lg text-sm font-medium text-white bg-slate-500 hover:bg-white hover:text-slate-500 transition-colors">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Reusable Confirmation Modal --}}
            <div id="confirmationModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
                <div class="relative bg-white w-full max-w-sm rounded-2xl shadow-2xl p-6 text-center transform scale-95 opacity-0 transition-all duration-300 ease-out" id="confirmation-modal-panel">
                    <div id="confirmation-modal-icon" class="w-12 h-12 rounded-full p-2 flex items-center justify-center mx-auto mb-4">
                        {{-- Icon will be set by JS --}}
                    </div>
                    <h3 id="confirmation-modal-title" class="text-lg font-semibold text-slate-800"></h3>
                    <p id="confirmation-modal-message" class="text-sm text-slate-500 mt-2"></p>
                    <div class="mt-6 flex justify-center gap-4">
                        <button id="cancel-confirmation-button" class="w-full px-6 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-lg hover:bg-slate-200 transition-all">No</button>
                        <button id="confirm-action-button" class="w-full px-6 py-2.5 text-sm font-medium text-white rounded-lg transition-all">Yes</button>
                    </div>
                </div>
            </div>

            {{-- Reusable Success Modal --}}
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
        </div>

        {{-- Add Program Modal --}}
        <div id="addProgramModal" class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out" id="program-modal-panel">
                    <button id="closeProgramModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <div class="text-center mb-6">
                        <h2 class="text-xl font-bold text-slate-800">Add New Curriculum Name</h2>
                        <p class="text-sm text-slate-500 mt-1">Create a new program entry for the dropdown.</p>
                    </div>

                    <form id="programForm" class="space-y-4">
                        @csrf
                        <div>
                            <label for="newProgramDescription" class="block text-sm font-medium text-slate-700 mb-1">Curriculum Name</label>
                            <input type="text" id="newProgramDescription" name="description" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Bachelor of Science in Information Technology" required>
                        </div>
                        <div>
                            <label for="newProgramCode" class="block text-sm font-medium text-slate-700 mb-1">Program Code</label>
                            <input type="text" id="newProgramCode" name="code" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. BSIT" required>
                        </div>
                        <div>
                            <label for="newProgramDepartment" class="block text-sm font-medium text-slate-700 mb-1">Level</label>
                            <select id="newProgramDepartment" name="department" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="" disabled selected>Select Level</option>
                                <option value="College">College</option>
                                <option value="Senior High">Senior High</option>
                            </select>
                        </div>
                        <div class="pt-4 flex gap-3">
                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Add Curriculum
                            </button>
                            <button type="button" id="cancelProgramButton" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Add Program Modal --}}
        <div id="addProgramModal" class="fixed inset-0 z-[60] overflow-y-auto bg-slate-900/50 backdrop-blur-sm transition-opacity duration-300 ease-out hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl p-6 md:p-8 transform scale-95 opacity-0 transition-all duration-300 ease-out" id="program-modal-panel">
                    <button id="closeProgramModalButton" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 focus:outline-none transition-colors duration-200 rounded-full p-1 hover:bg-slate-100">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <div class="text-center mb-6">
                        <h2 class="text-xl font-bold text-slate-800">Add New Curriculum Name</h2>
                        <p class="text-sm text-slate-500 mt-1">Create a new program entry for the dropdown.</p>
                    </div>

                    <form id="programForm" class="space-y-4">
                        @csrf
                        <div>
                            <label for="newProgramDescription" class="block text-sm font-medium text-slate-700 mb-1">Curriculum Name</label>
                            <input type="text" id="newProgramDescription" name="description" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. Bachelor of Science in Information Technology" required>
                        </div>
                        <div>
                            <label for="newProgramCode" class="block text-sm font-medium text-slate-700 mb-1">Program Code</label>
                            <input type="text" id="newProgramCode" name="code" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g. BSIT" required>
                        </div>
                        <div>
                            <label for="newProgramDepartment" class="block text-sm font-medium text-slate-700 mb-1">Level</label>
                            <select id="newProgramDepartment" name="department" class="w-full px-4 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="" disabled selected>Select Level</option>
                                <option value="College">College</option>
                                <option value="Senior High">Senior High</option>
                            </select>
                        </div>
                        <div class="pt-4 flex gap-3">
                            <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Add Curriculum
                            </button>
                            <button type="button" id="cancelProgramButton" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200 transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Custom Calendar Picker Styling */
        #expirationDateDisplay {
            color: #475569;
            font-size: 0.875rem;
        }
        
        #expirationDateDisplay:not(:placeholder-shown) {
            background-color: #eff6ff;
            border-color: #3b82f6;
            font-weight: 500;
            color: #1e40af;
        }
        
        /* Calendar day buttons */
        .calendar-day {
            width: 100%;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            cursor: pointer;
            color: #1e293b;
        }
        
        .calendar-day:hover:not(.other-month):not(.selected) {
            background-color: #f1f5f9;
        }
        
        .calendar-day.other-month {
            color: #cbd5e1;
            cursor: default;
        }
        
        .calendar-day.today {
            border: 2px solid #3b82f6;
            font-weight: 600;
        }
        
        .calendar-day.selected {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
        }
        
        .calendar-day.selected:hover {
            background-color: #2563eb;
        }
        
        /* Calendar animation */
        @keyframes calendarSlideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        #customCalendar:not(.hidden) {
            animation: calendarSlideIn 0.2s ease;
        }
        
        /* Year picker buttons */
        .year-button {
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.15s ease;
            cursor: pointer;
            color: #1e293b;
            text-align: center;
        }
        
        .year-button:hover:not(.current-year) {
            background-color: #f1f5f9;
        }
        
        .year-button.current-year {
            background-color: #dbeafe;
            color: #1e40af;
            font-weight: 600;
        }
        
        .year-button.selected-year {
            background-color: #3b82f6;
            color: white;
            font-weight: 600;
        }
        
        .year-button.selected-year:hover {
            background-color: #2563eb;
        }
        
        /* Toggle arrow rotation */
        #toggleArrow.rotated {
            transform: rotate(180deg);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Main elements
            const addCurriculumButton = document.getElementById('addCurriculumButton');
            const seniorHighCurriculums = document.getElementById('senior-high-curriculums');
            const collegeCurriculums = document.getElementById('college-curriculums');
            const searchBar = document.getElementById('search-bar');
            const versionFilter = document.getElementById('version-filter');
            
            // New form elements
            const complianceSelect = document.getElementById('compliance');
            const memorandumContainer = document.getElementById('memorandumContainer');
            const yearContainer = document.getElementById('yearContainer');
            const categoryContainer = document.getElementById('categoryContainer');
            const memorandumYearSelect = document.getElementById('memorandumYear');
            const memorandumCategorySelect = document.getElementById('memorandumCategory');
            const memorandumSelect = document.getElementById('memorandum');
            const yearLevelSelect = document.getElementById('yearLevel');
            const unitsContainer = document.getElementById('unitsContainer');
            const semesterInputs = document.getElementById('semesterInputs');
            const totalUnitsDisplay = document.getElementById('totalUnits');

            // Add/Edit Modal elements
            const addCurriculumModal = document.getElementById('addCurriculumModal');
            const closeModalButton = document.getElementById('closeModalButton');
            const cancelModalButton = document.getElementById('cancelModalButton');
            const modalPanel = document.getElementById('modal-panel');
            const curriculumForm = document.getElementById('curriculumForm');
            const modalTitle = document.getElementById('modal-title');
            const submitButton = document.getElementById('submit-button');
            const curriculumIdField = document.getElementById('curriculumId');

            // Add Program Modal Elements
            const addNewProgramButton = document.getElementById('addNewProgramButton');
            const addProgramModal = document.getElementById('addProgramModal');
            const closeProgramModalButton = document.getElementById('closeProgramModalButton');
            const cancelProgramButton = document.getElementById('cancelProgramButton');
            const programModalPanel = document.getElementById('program-modal-panel');
            const programForm = document.getElementById('programForm');

            // Custom Searchable Dropdown Elements
            const curriculumDropdownButton = document.getElementById('curriculumDropdownButton');
            const curriculumDropdownMenu = document.getElementById('curriculumDropdownMenu');
            const curriculumDropdownArrow = document.getElementById('curriculumDropdownArrow');
            const curriculumSelectedText = document.getElementById('curriculumSelectedText');
            const curriculumSearchInput = document.getElementById('curriculumSearchInput');
            const curriculumOptionsList = document.getElementById('curriculumOptionsList');

            // Confirmation Modal elements
            const confirmationModal = document.getElementById('confirmationModal');
            const confirmationModalPanel = document.getElementById('confirmation-modal-panel');
            const confirmationModalTitle = document.getElementById('confirmation-modal-title');
            const confirmationModalMessage = document.getElementById('confirmation-modal-message');
            const confirmationModalIcon = document.getElementById('confirmation-modal-icon');
            const cancelConfirmationButton = document.getElementById('cancel-confirmation-button');
            const confirmActionButton = document.getElementById('confirm-action-button');

            // Success Modal elements
            const successModal = document.getElementById('successModal');
            const successModalPanel = document.getElementById('success-modal-panel');
            const successModalTitle = document.getElementById('success-modal-title');
            const successModalMessage = document.getElementById('success-modal-message');
            const closeSuccessModalButton = document.getElementById('closeSuccessModalButton');

            // Duplicate Detection elements
            const curriculumInput = document.getElementById('curriculum');
            const duplicateAlert = document.getElementById('duplicateAlert');
            const duplicateList = document.getElementById('duplicateList');

            const duplicateMemorandumAlert = document.getElementById('duplicateMemorandumAlert');

            // Custom Calendar Picker elements
            const expirationDateDisplay = document.getElementById('expirationDateDisplay');
            const expirationDateInput = document.getElementById('expirationDate');
            const clearExpirationDateButton = document.getElementById('clearExpirationDate');
            const customCalendar = document.getElementById('customCalendar');
            const calendarDays = document.getElementById('calendarDays');
            const currentMonthYear = document.getElementById('currentMonthYear');
            const prevMonthBtn = document.getElementById('prevMonth');
            const nextMonthBtn = document.getElementById('nextMonth');
            const todayBtn = document.getElementById('todayBtn');
            const clearDateBtn = document.getElementById('clearDateBtn');
            const monthYearToggle = document.getElementById('monthYearToggle');
            const toggleArrow = document.getElementById('toggleArrow');
            const monthView = document.getElementById('monthView');
            const yearView = document.getElementById('yearView');
            const yearGrid = document.getElementById('yearGrid');

            let currentAction = null; // To store the function to execute on confirmation.
            let matchingCurriculums = []; // Store matching curriculums for duplicate detection
            let createAnotherMode = false; // Flag to allow creating another curriculum
            
            // --- Custom Calendar Picker Functionality ---
            let currentDate = new Date();
            let selectedDate = null;
            let isYearView = false;
            let yearRangeStart = new Date().getFullYear() - 8; // Start 8 years before current
            
            // Format date for display
            const formatDateDisplay = (date) => {
                const options = { month: 'short', day: 'numeric', year: 'numeric' };
                return date.toLocaleDateString('en-US', options);
            };
            
            // Format date for input value (YYYY-MM-DD)
            const formatDateValue = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };
            
            // Toggle between month and year view
            const toggleView = () => {
                isYearView = !isYearView;
                
                if (isYearView) {
                    monthView.classList.add('hidden');
                    yearView.classList.remove('hidden');
                    toggleArrow.classList.add('rotated');
                    generateYearPicker();
                } else {
                    yearView.classList.add('hidden');
                    monthView.classList.remove('hidden');
                    toggleArrow.classList.remove('rotated');
                    generateCalendar();
                }
            };
            
            // Generate year picker grid
            const generateYearPicker = () => {
                yearGrid.innerHTML = '';
                const currentYear = new Date().getFullYear();
                const selectedYear = selectedDate ? selectedDate.getFullYear() : null;
                
                // Show 16 years (4x4 grid)
                for (let i = 0; i < 16; i++) {
                    const year = yearRangeStart + i;
                    const yearBtn = document.createElement('button');
                    yearBtn.type = 'button';
                    yearBtn.className = 'year-button';
                    yearBtn.textContent = year;
                    
                    if (year === currentYear) {
                        yearBtn.classList.add('current-year');
                    }
                    
                    if (year === selectedYear) {
                        yearBtn.classList.add('selected-year');
                    }
                    
                    yearBtn.addEventListener('click', () => {
                        currentDate.setFullYear(year);
                        isYearView = false;
                        monthView.classList.remove('hidden');
                        yearView.classList.add('hidden');
                        toggleArrow.classList.remove('rotated');
                        generateCalendar();
                    });
                    
                    yearGrid.appendChild(yearBtn);
                }
                
                // Update header to show year range
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                                   'July', 'August', 'September', 'October', 'November', 'December'];
                const month = currentDate.getMonth();
                currentMonthYear.textContent = `${monthNames[month]} ${currentDate.getFullYear()}`;
            };
            
            // Generate calendar for current month
            const generateCalendar = () => {
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();
                
                // Update header
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                                   'July', 'August', 'September', 'October', 'November', 'December'];
                currentMonthYear.textContent = `${monthNames[month]} ${year}`;
                
                // Clear calendar
                calendarDays.innerHTML = '';
                
                // Get first day of month and number of days
                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();
                const daysInPrevMonth = new Date(year, month, 0).getDate();
                
                const today = new Date();
                today.setHours(0, 0, 0, 0);
                
                // Add previous month's days
                for (let i = firstDay - 1; i >= 0; i--) {
                    const day = daysInPrevMonth - i;
                    const dayBtn = document.createElement('button');
                    dayBtn.type = 'button';
                    dayBtn.className = 'calendar-day other-month';
                    dayBtn.textContent = day;
                    calendarDays.appendChild(dayBtn);
                }
                
                // Add current month's days
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayBtn = document.createElement('button');
                    dayBtn.type = 'button';
                    dayBtn.className = 'calendar-day';
                    dayBtn.textContent = day;
                    
                    const currentDayDate = new Date(year, month, day);
                    currentDayDate.setHours(0, 0, 0, 0);
                    
                    // Check if today
                    if (currentDayDate.getTime() === today.getTime()) {
                        dayBtn.classList.add('today');
                    }
                    
                    // Check if selected
                    if (selectedDate) {
                        const selected = new Date(selectedDate);
                        selected.setHours(0, 0, 0, 0);
                        if (currentDayDate.getTime() === selected.getTime()) {
                            dayBtn.classList.add('selected');
                        }
                    }
                    
                    // Add click handler
                    dayBtn.addEventListener('click', () => {
                        selectDate(new Date(year, month, day));
                    });
                    
                    calendarDays.appendChild(dayBtn);
                }
                
                // Add next month's days to fill grid
                const totalCells = calendarDays.children.length;
                const remainingCells = 42 - totalCells; // 6 rows * 7 days
                for (let day = 1; day <= remainingCells; day++) {
                    const dayBtn = document.createElement('button');
                    dayBtn.type = 'button';
                    dayBtn.className = 'calendar-day other-month';
                    dayBtn.textContent = day;
                    calendarDays.appendChild(dayBtn);
                }
            };
            
            // Select a date
            const selectDate = (date) => {
                selectedDate = date;
                expirationDateDisplay.value = formatDateDisplay(date);
                expirationDateInput.value = formatDateValue(date);
                clearExpirationDateButton.classList.remove('hidden');
                customCalendar.classList.add('hidden');
                generateCalendar(); // Refresh to show selection
            };
            
            // Show/hide calendar
            expirationDateDisplay.addEventListener('click', () => {
                customCalendar.classList.toggle('hidden');
                if (!customCalendar.classList.contains('hidden')) {
                    generateCalendar();
                }
            });
            
            // Toggle between month and year view
            monthYearToggle.addEventListener('click', toggleView);
            
            // Month/Year navigation
            prevMonthBtn.addEventListener('click', () => {
                if (isYearView) {
                    yearRangeStart -= 16;
                    generateYearPicker();
                } else {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    generateCalendar();
                }
            });
            
            nextMonthBtn.addEventListener('click', () => {
                if (isYearView) {
                    yearRangeStart += 16;
                    generateYearPicker();
                } else {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    generateCalendar();
                }
            });
            
            // Today button
            todayBtn.addEventListener('click', () => {
                selectDate(new Date());
            });
            
            // Clear button in calendar
            clearDateBtn.addEventListener('click', () => {
                selectedDate = null;
                expirationDateDisplay.value = '';
                expirationDateInput.value = '';
                clearExpirationDateButton.classList.add('hidden');
                customCalendar.classList.add('hidden');
            });
            
            // Clear button next to input
            clearExpirationDateButton.addEventListener('click', () => {
                selectedDate = null;
                expirationDateDisplay.value = '';
                expirationDateInput.value = '';
                clearExpirationDateButton.classList.add('hidden');
            });
            
            // Close calendar when clicking outside
            document.addEventListener('click', (e) => {
                if (!customCalendar.contains(e.target) && 
                    !expirationDateDisplay.contains(e.target)) {
                    customCalendar.classList.add('hidden');
                }
            });
            
            // Initialize if there's a pre-existing value
            if (expirationDateInput.value) {
                selectedDate = new Date(expirationDateInput.value);
                expirationDateDisplay.value = formatDateDisplay(selectedDate);
                clearExpirationDateButton.classList.remove('hidden');
            }
            

            // Memorandum data organized by year - fetched from compliance validator structure
            // DepEd memorandum categories (kept static as they are not year-based)
            // Function to populate CHED years (matching compliance_validator range)
            const populateCHEDYears = () => {
                const currentValue = memorandumYearSelect.value;
                memorandumYearSelect.innerHTML = '<option value="" disabled selected>Select Year</option>';
                for (let year = 2025; year >= 1994; year--) {
                    const option = document.createElement('option');
                    option.value = year;
                    option.textContent = year;
                    memorandumYearSelect.appendChild(option);
                }
                if (currentValue) memorandumYearSelect.value = currentValue;
            };

            // Call it once to initialize
            populateCHEDYears();
            
            // Function to fetch memorandums based on compliance, year, or category
            const fetchMemorandumData = async (compliance, yearOrCategory = null) => {
                try {
                    if (!yearOrCategory) return [];

                    const response = await fetch(`/api/compliance-links?agency=${compliance}&year=${encodeURIComponent(yearOrCategory)}`);
                    if (!response.ok) throw new Error('API request failed');
                    const data = await response.json();

                    if (compliance === 'CHED') {
                        return data.map(link => link.title);
                    } else if (compliance === 'DepEd') {
                        // Extract Unique Groups (Titles)
                        // Groups come from two sources:
                        // 1. The 'group' column of normal links (e.g. link.group = 'ARTS...')
                        // 2. The 'title' column of Category records (e.g. link.title = 'ARTS...', link.is_category = 1)
                        const groups = [...new Set([
                            ...data.map(link => link.group).filter(g => g),
                            ...data.filter(link => link.is_category == 1 || link.is_category === true).map(link => link.title)
                        ])];
                        
                        if (groups.length > 0) {
                            return groups.sort();
                        } else {
                            // If no groups, return titles of actual links (e.g. Core, Shape Paper)
                            return data.map(link => link.title);
                        }
                    }
                    return [];
                } catch (error) {
                    console.error('Error fetching memorandum data:', error);
                    return [];
                }
            };

            // --- Modal Helper Functions ---
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
                    currentAction = null;
                }, 300);
            };

            closeSuccessModalButton.addEventListener('click', hideSuccessModal);
            cancelConfirmationButton.addEventListener('click', hideConfirmationModal);
            confirmActionButton.addEventListener('click', () => {
                if (typeof currentAction === 'function') {
                    currentAction();
                }
                hideConfirmationModal();
            });
            
            // --- Duplicate Detection and Browse Functionality ---
            
            // Function to check for duplicate curriculum names
            const checkDuplicateCurriculum = () => {
                const curriculumName = curriculumInput.value.trim();
                
                // Don't check if field is empty or in edit mode (already has an ID)
                if (!curriculumName || curriculumIdField.value) {
                    duplicateAlert.classList.add('hidden');
                    matchingCurriculums = [];
                    return;
                }
                
                // Don't check if in "create another" mode
                if (createAnotherMode) {
                    return;
                }
                
                // Search for matching curriculums (case-insensitive) - Filter OUT Approved AND Old as per user request
                if (window.curriculumsData) {
                    matchingCurriculums = window.curriculumsData.filter(curr => 
                        curr.curriculum_name.toLowerCase() === curriculumName.toLowerCase() &&
                        curr.approval_status !== 'approved' &&
                        curr.version_status !== 'old'
                    );
                    
                    if (matchingCurriculums.length > 0) {
                        // Show duplicate alert
                        showDuplicateAlert(matchingCurriculums);
                    } else {
                        // Hide duplicate alert
                        duplicateAlert.classList.add('hidden');
                    }
                }
            };
            
            // Function to show duplicate alert with curriculum list
            const showDuplicateAlert = (curriculums) => {
                duplicateList.innerHTML = '';
                
                curriculums.forEach(curr => {
                    const currItem = document.createElement('div');
                    currItem.className = 'p-2 bg-white rounded border border-amber-300';
                    
                    const memorandumInfo = curr.memorandum 
                        ? (curr.memorandum_year ? `${curr.memorandum_year} • ` : '') + 
                          (curr.memorandum_category ? `${curr.memorandum_category} • ` : '') +
                          curr.memorandum.substring(0, 40) + '...'
                        : 'No memorandum';
                    
                    const statusBadge = curr.approval_status === 'approved' 
                        ? '<span class="px-1.5 py-0.5 bg-green-100 text-green-800 rounded text-xs">Approved</span>'
                        : curr.approval_status === 'rejected'
                        ? '<span class="px-1.5 py-0.5 bg-red-100 text-red-800 rounded text-xs">Rejected</span>'
                        : '<span class="px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded text-xs">Processing</span>';
                    
                    currItem.innerHTML = `
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-grow min-w-0">
                                <div class="font-medium text-amber-900">${curr.program_code} • ${curr.academic_year}</div>
                                <div class="text-xs text-amber-700 truncate">${memorandumInfo}</div>
                            </div>
                            ${statusBadge}
                        </div>
                    `;
                    
                    duplicateList.appendChild(currItem);
                });
                
                duplicateAlert.classList.remove('hidden');
            };
            

            
            // Function to load a curriculum for editing
            const loadCurriculumForEditing = (curriculum) => {
                // Hide duplicate alert
                duplicateAlert.classList.add('hidden');
                
                // Use the existing showAddEditModal function
                showAddEditModal(true, curriculum);
            };
            

            
            // --- Custom Searchable Dropdown Functionality ---
            
            // Toggle dropdown
            curriculumDropdownButton.addEventListener('click', () => {
                const isHidden = curriculumDropdownMenu.classList.contains('hidden');
                if (isHidden) {
                    curriculumDropdownMenu.classList.remove('hidden');
                    curriculumDropdownArrow.style.transform = 'rotate(180deg)';
                    curriculumSearchInput.focus();
                } else {
                    curriculumDropdownMenu.classList.add('hidden');
                    curriculumDropdownArrow.style.transform = 'rotate(0deg)';
                    curriculumSearchInput.value = '';
                    filterCurriculumOptions('');
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!curriculumDropdownButton.contains(e.target) && !curriculumDropdownMenu.contains(e.target)) {
                    curriculumDropdownMenu.classList.add('hidden');
                    curriculumDropdownArrow.style.transform = 'rotate(0deg)';
                    curriculumSearchInput.value = '';
                    filterCurriculumOptions('');
                }
            });

            // Search functionality
            curriculumSearchInput.addEventListener('input', (e) => {
                filterCurriculumOptions(e.target.value);
            });

            // Filter options based on search
            const filterCurriculumOptions = (searchTerm) => {
                const options = curriculumOptionsList.querySelectorAll('.curriculum-option');
                const groups = curriculumOptionsList.querySelectorAll('.curriculum-group');
                const lowerSearch = searchTerm.toLowerCase();

                groups.forEach(group => {
                    const groupOptions = group.querySelectorAll('.curriculum-option');
                    let hasVisibleOptions = false;

                    groupOptions.forEach(option => {
                        const text = option.dataset.value.toLowerCase();
                        if (text.includes(lowerSearch)) {
                            option.style.display = 'block';
                            hasVisibleOptions = true;
                        } else {
                            option.style.display = 'none';
                        }
                    });

                    // Hide group if no visible options
                    group.style.display = hasVisibleOptions ? 'block' : 'none';
                });
            };

            // Handle option selection
            curriculumOptionsList.addEventListener('click', (e) => {
                const option = e.target.closest('.curriculum-option');
                if (!option) return;

                const value = option.dataset.value;
                const code = option.dataset.code;
                const department = option.dataset.department;

                // Update hidden select
                curriculumInput.value = value;
                
                // Update display text
                curriculumSelectedText.textContent = value;
                curriculumSelectedText.classList.remove('text-slate-500');
                curriculumSelectedText.classList.add('text-slate-700');

                // Close dropdown
                curriculumDropdownMenu.classList.add('hidden');
                curriculumDropdownArrow.style.transform = 'rotate(0deg)';
                curriculumSearchInput.value = '';
                filterCurriculumOptions('');

                // Trigger change event on hidden select
                curriculumInput.dispatchEvent(new Event('change'));
            });

            
            // Update Program Code and Level when Curriculum is selected
            curriculumInput.addEventListener('change', () => {
                const selectedOption = curriculumInput.options[curriculumInput.selectedIndex];
                if (!selectedOption || selectedOption.disabled) return;
                
                const code = selectedOption.getAttribute('data-code');
                const programCodeInput = document.getElementById('programCode');
                const department = selectedOption.closest('optgroup')?.label;
                const yearLevelSelect = document.getElementById('yearLevel');

                if (code) {
                    programCodeInput.value = code;
                    programCodeInput.dispatchEvent(new Event('input'));
                }

                if (department) {
                    yearLevelSelect.value = department;
                    yearLevelSelect.dispatchEvent(new Event('change'));
                }
                
                // Reset create another mode
                createAnotherMode = false;

                checkDuplicateCurriculum();
            });

            // Event listeners for duplicate detection
            // Removed browse functionality as it is replaced by the dropdown
            
            // Browse search functionality - REMOVED
            
            // Close browse dropdown when clicking outside - REMOVED
            
            // Function to check for duplicate memorandum
            const checkDuplicateMemorandum = () => {
                // Only check if in "create another" mode
                if (!createAnotherMode) {
                    duplicateMemorandumAlert.classList.add('hidden');
                    return;
                }
                
                const curriculumName = curriculumInput.value.trim();
                const selectedMemorandum = memorandumSelect.value;
                
                // Don't check if no curriculum name or no memorandum selected
                if (!curriculumName || !selectedMemorandum) {
                    duplicateMemorandumAlert.classList.add('hidden');
                    return;
                }
                
                // Check if any matching curriculum has the same memorandum
                if (window.curriculumsData && matchingCurriculums.length > 0) {
                    const hasDuplicateMemorandum = matchingCurriculums.some(curr => 
                        curr.memorandum === selectedMemorandum
                    );
                    
                    if (hasDuplicateMemorandum) {
                        duplicateMemorandumAlert.classList.remove('hidden');
                    } else {
                        duplicateMemorandumAlert.classList.add('hidden');
                    }
                } else {
                    duplicateMemorandumAlert.classList.add('hidden');
                }
            };
            
            // Add event listener to memorandum select
            memorandumSelect.addEventListener('change', checkDuplicateMemorandum);
            
            // --- Dynamic Form Logic ---
            
            // Handle compliance selection
            complianceSelect.addEventListener('change', function() {
                const selectedCompliance = this.value;
                
                if (selectedCompliance === 'CHED') {
                    // Show year selection for CHED
                    yearContainer.classList.remove('hidden');
                    categoryContainer.classList.add('hidden');
                    memorandumSelect.innerHTML = '<option value="" disabled selected>Please select a year first</option>';
                    memorandumContainer.classList.remove('hidden');
                    
                    // Manage validation
                    memorandumYearSelect.setAttribute('required', 'required');
                    memorandumCategorySelect.removeAttribute('required');
                } else if (selectedCompliance === 'DepEd') {
                    // Show category selection for DepEd
                    categoryContainer.classList.remove('hidden');
                    yearContainer.classList.add('hidden');
                    memorandumSelect.innerHTML = '<option value="" disabled selected>Please select a category first</option>';
                    memorandumContainer.classList.remove('hidden');
                    
                    // Manage validation
                    memorandumCategorySelect.setAttribute('required', 'required');
                    memorandumYearSelect.removeAttribute('required');
                } else {
                    memorandumContainer.classList.add('hidden');
                    yearContainer.classList.add('hidden');
                    categoryContainer.classList.add('hidden');
                    
                    // Remove validation when hidden
                    memorandumYearSelect.removeAttribute('required');
                    memorandumCategorySelect.removeAttribute('required');
                    memorandumSelect.removeAttribute('required');
                }
            });
            
            // Handle year selection for CHED
            memorandumYearSelect.addEventListener('change', function() {
                const selectedYear = this.value;
                const selectedCompliance = complianceSelect.value;
                
                if (selectedCompliance === 'CHED' && selectedYear) {
                    loadMemorandums(selectedCompliance, selectedYear);
                }
            });
            
            // Handle category selection for DepEd
            memorandumCategorySelect.addEventListener('change', function() {
                const selectedCategory = this.value;
                const selectedCompliance = complianceSelect.value;
                
                if (selectedCompliance === 'DepEd' && selectedCategory) {
                    loadMemorandums(selectedCompliance, selectedCategory);
                }
            });
            
            // Function to load memorandums
            const loadMemorandums = async (compliance, yearOrCategory = null) => {
                memorandumSelect.innerHTML = '<option value="" disabled selected>Loading memorandums...</option>';
                
                try {
                    const memorandums = await fetchMemorandumData(compliance, yearOrCategory);
                    memorandumSelect.innerHTML = '<option value="" disabled selected>Select Memorandum</option>';
                    
                    memorandums.forEach(memo => {
                        const option = document.createElement('option');
                        option.value = memo;
                        option.textContent = memo;
                        memorandumSelect.appendChild(option);
                    });
                    
                    // Add required validation when memorandums are loaded
                    if (memorandums.length > 0) {
                        memorandumSelect.setAttribute('required', 'required');
                    }
                } catch (error) {
                    console.error('Error loading memorandums:', error);
                    memorandumSelect.innerHTML = '<option value="" disabled selected>Error loading memorandums</option>';
                }
            };
            
            // Handle year level selection for units
            yearLevelSelect.addEventListener('change', function() {
                const selectedLevel = this.value;
                generateSemesterInputs(selectedLevel);
                
                // Auto-select compliance based on level
                if (selectedLevel === 'College') {
                    complianceSelect.value = 'CHED';
                    complianceSelect.dispatchEvent(new Event('change'));
                } else if (selectedLevel === 'Senior High') {
                    complianceSelect.value = 'DepEd';
                    complianceSelect.dispatchEvent(new Event('change'));
                }
                
                const semesterUnitsLabel = document.getElementById('semesterUnitsLabel');
                const academicYearContainer = document.getElementById('academicYearContainer');
                const academicYearInput = document.getElementById('academicYear');
                const expirationDateContainer = document.getElementById('expirationDateContainer');

                if (selectedLevel === 'Senior High') {
                    // Hide units section for Senior High (they don't use units)
                    unitsContainer.classList.add('hidden');
                    // Hide Academic Year for Senior High
                    if(academicYearContainer) academicYearContainer.classList.add('hidden');
                    if(academicYearInput) {
                        academicYearInput.removeAttribute('required');
                        academicYearInput.value = ''; // Clear the value to prevent validation errors
                    }
                    // Hide Expiration Date for Senior High
                    if(expirationDateContainer) expirationDateContainer.classList.add('hidden');
                } else {
                    semesterUnitsLabel.textContent = 'Semester Units';
                    if (selectedLevel) {
                        unitsContainer.classList.remove('hidden');
                    } else {
                        unitsContainer.classList.add('hidden');
                    }
                    // Show Academic Year for others
                    if(academicYearContainer) academicYearContainer.classList.remove('hidden');
                    if(academicYearInput) academicYearInput.setAttribute('required', 'required');
                    // Show Expiration Date
                    if(expirationDateContainer) expirationDateContainer.classList.remove('hidden');
                }
            });
            
            // Generate semester inputs based on level
            function generateSemesterInputs(level) {
                semesterInputs.innerHTML = '';
                let semesters = [];
                
                if (level === 'College') {
                    semesters = [
                        '1st Year First Semester',
                        '1st Year Second Semester',
                        '2nd Year First Semester',
                        '2nd Year Second Semester',
                        '3rd Year First Semester',
                        '3rd Year Second Semester',
                        '4th Year First Semester',
                        '4th Year Second Semester'
                    ];
                } else if (level === 'Senior High') {
                    semesters = [
                        '1st Year First Quarter',
                        '1st Year Second Quarter',
                        '2nd Year Third Quarter',
                        '2nd Year Fourth Quarter'
                    ];
                }
                
                semesters.forEach((semester, index) => {
                    const inputGroup = document.createElement('div');
                    inputGroup.className = 'flex items-center gap-3';
                    inputGroup.innerHTML = `
                        <label class="text-sm font-medium text-slate-700 w-48 flex-shrink-0">${semester}:</label>
                        <div class="relative flex-grow">
                            <input type="number" 
                                   id="semester_${index}" 
                                   name="semester_units[${index}]" 
                                   class="semester-unit-input w-full pl-3 pr-8 py-2 bg-slate-50 border border-slate-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                   placeholder="0" 
                                   min="0" 
                                   step="0.5">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-slate-500">units</span>
                        </div>
                    `;
                    semesterInputs.appendChild(inputGroup);
                });
                
                // Add event listeners for automatic calculation
                document.querySelectorAll('.semester-unit-input').forEach(input => {
                    input.addEventListener('input', calculateTotalUnits);
                });
                
                calculateTotalUnits();
            }
            
            // Calculate total units
            function calculateTotalUnits() {
                const inputs = document.querySelectorAll('.semester-unit-input');
                let total = 0;
                
                inputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });
                
                // Format total units without .0 for whole numbers
                const formattedTotal = total % 1 === 0 ? Math.floor(total) : total.toFixed(1);
                totalUnitsDisplay.textContent = formattedTotal;
            }

            // --- Card & API Logic ---
            const createCurriculumCard = (curriculum) => {
                const card = document.createElement('div');
                
                // Determine card border, icon, and title colors based on approval status
                const approvalStatus = curriculum.approval_status || 'processing';
                
                // Check if expired (compare dates ignoring time)
                const isExpired = curriculum.expiration_date && new Date(curriculum.expiration_date).setHours(0,0,0,0) <= new Date().setHours(0,0,0,0);
                
                // Determine effective version (explicitly set to old, OR expired)
                const effectiveVersion = (curriculum.version_status === 'old' || isExpired) ? 'old' : 'new';

                let cardBorderClass = 'border-slate-200 hover:border-blue-500';
                let iconBgClass = 'bg-slate-100 group-hover:bg-blue-100';
                let iconColorClass = 'text-slate-500 group-hover:text-blue-600';
                let titleColorClass = 'text-slate-800 group-hover:text-blue-600';
                
                if (approvalStatus === 'approved') {
                    cardBorderClass = 'border-green-400 hover:border-green-500';
                    iconBgClass = 'bg-green-100 group-hover:bg-green-200';
                    iconColorClass = 'text-green-600 group-hover:text-green-700';
                    titleColorClass = 'text-green-700 group-hover:text-green-800';
                } else if (approvalStatus === 'rejected') {
                    cardBorderClass = 'border-red-400 hover:border-red-500';
                    iconBgClass = 'bg-red-100 group-hover:bg-red-200';
                    iconColorClass = 'text-red-600 group-hover:text-red-700';
                    titleColorClass = 'text-red-700 group-hover:text-red-800';
                }
                
                card.className = `curriculum-card group relative bg-white p-4 rounded-xl border ${cardBorderClass} flex items-center gap-4 hover:shadow-lg transition-all duration-300`;
                card.dataset.name = curriculum.curriculum_name.toLowerCase();
                card.dataset.code = curriculum.program_code.toLowerCase();
                card.dataset.id = curriculum.id;
                card.dataset.version = effectiveVersion;
                card.dataset.approvalStatus = approvalStatus;

                const date = new Date(curriculum.created_at);
                const formattedDate = date.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                const formattedTime = date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

                // Helper function to truncate long memorandum text
                const truncateText = (text, maxLength = 60) => {
                    if (!text) return 'Not specified';
                    return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
                };

                // Format compliance badge
                const complianceBadge = curriculum.compliance 
                    ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${curriculum.compliance === 'CHED' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'}">
                        ${curriculum.compliance}
                    </span>`
                    : '';

                // Format total units display (remove .0 from whole numbers)
                const formatUnits = (units) => {
                    if (!units) return '';
                    const num = parseFloat(units);
                    return num % 1 === 0 ? Math.floor(num) : num;
                };

                // Calculate Completion Percentage (College)
                let completionPercent = 0;
                let mappedUnits = parseFloat(curriculum.mapped_units || 0);
                let totalUnits = parseFloat(curriculum.total_units || 0);
                
                if (curriculum.year_level === 'College' && totalUnits > 0) {
                    completionPercent = Math.min(100, Math.round((mappedUnits / totalUnits) * 100));
                }

                const totalUnitsDisplay = totalUnits > 0
                    ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800" title="Mapped: ${formatUnits(mappedUnits)} / ${formatUnits(totalUnits)}">
                        ${formatUnits(totalUnits)} units
                    </span>`
                    : '';

                // Version status badge - Only show if approved
                let versionBadge = '';
                if (approvalStatus === 'approved') {
                    versionBadge = effectiveVersion === 'old'
                        ? `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                            </svg>
                            Old
                        </span>`
                        : `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                            </svg>
                            New
                        </span>`;
                }

                // Approval status badge
                let approvalBadge = '';
                if (approvalStatus === 'approved') {
                    approvalBadge = `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        Approved
                    </span>`;
                } else if (approvalStatus === 'rejected') {
                    approvalBadge = `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                        Rejected
                    </span>`;
                } else {
                    approvalBadge = `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                        </svg>
                        Processing
                    </span>`;
                }

                // Format memorandum year/category display
                const memorandumYearCategory = curriculum.memorandum_year 
                    ? curriculum.memorandum_year
                    : curriculum.memorandum_category 
                        ? curriculum.memorandum_category 
                        : '';


                // Action buttons based on status
                let actionButtons = '';
                
                // Show if Processing AND (College >= 75% OR Not College & has subjects)
                const showActionButtons = (approvalStatus === 'processing') && 
                                        ((curriculum.year_level === 'College' && completionPercent >= 75) || 
                                         (curriculum.year_level !== 'College' && curriculum.subjects_count > 0));

                if (showActionButtons) {
                    const isSeniorHigh = curriculum.year_level === 'Senior High';
                    
                    actionButtons = `
                        <div class="flex gap-2 mt-2">
                            <button onclick="event.stopPropagation(); approveCurriculum(${curriculum.id})" 
                                    class="approve-btn px-3 py-1.5 bg-transparent border border-green-600 text-green-600 hover:bg-green-600 hover:text-white text-xs font-medium rounded-lg transition-all duration-200 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                Approve
                            </button>
                    `;
                    
                    if (!isSeniorHigh) {
                        actionButtons += `
                            <button onclick="event.stopPropagation(); rejectCurriculum(${curriculum.id})" 
                                    class="reject-btn px-3 py-1.5 bg-transparent border border-red-600 text-red-600 hover:bg-red-600 hover:text-white text-xs font-medium rounded-lg transition-all duration-200 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                                Reject
                            </button>
                        `;
                    }
                    
                    actionButtons += `</div>`;
                }


                card.innerHTML = `
                    <div class="flex-shrink-0 w-10 h-10 ${iconBgClass} rounded-lg flex items-center justify-center transition-colors duration-300">
                        <svg class="w-5 h-5 ${iconColorClass} transition-colors duration-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="flex-grow ${approvalStatus === 'approved' ? 'cursor-default' : 'cursor-pointer'} min-w-0" onclick="handleCardClick(${curriculum.id}, '${approvalStatus}')">
                        <div class="flex flex-col-reverse sm:flex-row items-start justify-between gap-2">
                            <div class="flex-grow min-w-0 w-full sm:pr-2">
                                <h3 class="font-bold ${titleColorClass} transition-colors duration-300 truncate mb-1">${curriculum.curriculum_name}</h3>
                                <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                                    <span>${curriculum.program_code}${curriculum.year_level === 'Senior High' ? '' : ` • ${curriculum.academic_year}`}</span>
                                    ${curriculum.expiration_date ? `
                                        <span class="flex items-center gap-1 text-xs text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            End Date: ${new Date(curriculum.expiration_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                                        </span>
                                    ` : ''}
                                </div>
                                ${curriculum.memorandum ? `
                                <p class="text-xs text-slate-400 truncate" title="${curriculum.memorandum}">
                                    ${memorandumYearCategory ? `${memorandumYearCategory} ` : ''}• ${truncateText(curriculum.memorandum, 45)}
                                </p>
                                ` : memorandumYearCategory ? `
                                <p class="text-xs text-slate-400">
                                    ${memorandumYearCategory} • No memorandum selected
                                </p>
                                ` : ''}
                                <p class="text-xs text-slate-400 mt-1">
                                    Created: ${formattedDate} at ${formattedTime} • 
                                    <span class="font-medium">${curriculum.subjects_count} subject${curriculum.subjects_count !== 1 ? 's' : ''}</span>
                                </p>
                            </div>
                            <div class="flex flex-col items-end sm:items-end gap-1 w-full sm:w-auto">
                                <div class="flex items-center gap-1 flex-wrap justify-end">
                                    ${complianceBadge}
                                    ${totalUnitsDisplay}
                                    ${curriculum.year_level === 'College' && totalUnits > 0 ? `
                                    <div class="relative overflow-hidden inline-flex items-center justify-center px-2.5 py-1 rounded-full border border-blue-100 bg-white min-w-[85px] shadow-sm" title="${formatUnits(mappedUnits)} / ${formatUnits(totalUnits)} units mapped">
                                        <!-- Water Fill Effect -->
                                        <div class="absolute bottom-0 left-0 w-full bg-blue-100/80 transition-all duration-700 ease-out border-t border-blue-200" 
                                             style="height: ${completionPercent}%"></div>
                                        
                                        <!-- Percentage Text -->
                                        <span class="relative z-10 text-[10px] font-bold ${completionPercent >= 75 ? 'text-blue-700' : 'text-slate-600'}">
                                            ${completionPercent}% Filled
                                        </span>
                                    </div>
                                    ` : ''}
                                    ${versionBadge}
                                    ${approvalBadge}
                                </div>
                                ${actionButtons}
                            </div>
                        </div>
                    </div>

                `;
                return card;
            };

            const renderCurriculums = (curriculums) => {
                seniorHighCurriculums.innerHTML = '';
                collegeCurriculums.innerHTML = '';
                let seniorHighCount = 0;
                let collegeCount = 0;

                curriculums.forEach(curriculum => {
                    const card = createCurriculumCard(curriculum);
                    if (curriculum.year_level === 'Senior High') {
                        seniorHighCurriculums.appendChild(card);
                        seniorHighCount++;
                    } else {
                        collegeCurriculums.appendChild(card);
                        collegeCount++;
                    }
                });

                if (seniorHighCount === 0) seniorHighCurriculums.innerHTML = '<p class="text-slate-500 text-sm py-4">No Senior High curriculums found.</p>';
                if (collegeCount === 0) collegeCurriculums.innerHTML = '<p class="text-slate-500 text-sm py-4">No College curriculums found.</p>';
                
                attachActionListeners();
                
                // Apply filter after rendering to hide old versions by default
                filterCurriculums();
            };
            
            const fetchCurriculums = () => {
                fetch('/api/curriculums')
                    .then(response => response.json())
                    .then(data => {
                        window.curriculumsData = data;
                        renderCurriculums(data);
                    })
                    .catch(error => console.error('Error fetching curriculums:', error));
            };

            const showAddEditModal = (isEdit = false, curriculum = null) => {
                curriculumForm.reset();
                
                // Reset duplicate detection state
                createAnotherMode = false;
                matchingCurriculums = [];
                duplicateAlert.classList.add('hidden');
                browseCurriculumsDropdown.classList.add('hidden');
                duplicateMemorandumAlert.classList.add('hidden');
                
                // Reset form state (remove read-only and disabled styles)
                const fieldsToReset = ['curriculum', 'programCode', 'academicYear', 'yearLevel', /* 'compliance' excluded to keep it read-only */ 'memorandum', 'memorandumYear', 'memorandumCategory'];
                fieldsToReset.forEach(id => {
                    const el = document.getElementById(id);
                    if(el) {
                        el.removeAttribute('readonly');
                        el.classList.remove('bg-gray-100', 'pointer-events-none');
                    }
                });
                curriculumForm.dataset.approvalStatus = ''; // Reset status

                 const modalSubTitle = document.querySelector('#modal-panel > div.text-center.mb-8 > p');
                if (isEdit && curriculum) {
                    modalTitle.textContent = 'Edit Curriculum';
                    modalSubTitle.textContent = 'Update the details for this curriculum.';
                    submitButton.querySelector('span').textContent = 'Update';
                    curriculumIdField.value = curriculum.id;
                    // Use curriculum_name from API response
                    const curriculumName = curriculum.curriculum_name || curriculum.curriculum || '';
                    document.getElementById('curriculum').value = curriculumName;
                    
                    // Update custom dropdown display
                    if (curriculumName) {
                        curriculumSelectedText.textContent = curriculumName;
                        curriculumSelectedText.classList.remove('text-slate-500');
                        curriculumSelectedText.classList.add('text-slate-700');
                    }
                    
                    document.getElementById('programCode').value = curriculum.program_code;
                    document.getElementById('academicYear').value = curriculum.academic_year;
                    if (curriculum.expiration_date) {
                        document.getElementById('expirationDate').value = curriculum.expiration_date;
                    }
                    document.getElementById('yearLevel').value = curriculum.year_level;
                    
                    // Set compliance and memorandum if available
                    if (curriculum.compliance) {
                        document.getElementById('compliance').value = curriculum.compliance;
                        complianceSelect.dispatchEvent(new Event('change'));
                        
                        // Set year if available and compliance is CHED
                        if (curriculum.compliance === 'CHED' && curriculum.memorandum_year) {
                            setTimeout(() => {
                                document.getElementById('memorandumYear').value = curriculum.memorandum_year;
                                memorandumYearSelect.dispatchEvent(new Event('change'));
                                
                                if (curriculum.memorandum) {
                                    setTimeout(() => {
                                        document.getElementById('memorandum').value = curriculum.memorandum;
                                    }, 200);
                                }
                            }, 100);
                        } else if (curriculum.compliance === 'DepEd' && curriculum.memorandum_category) {
                            // Set category if available and compliance is DepEd
                            setTimeout(() => {
                                document.getElementById('memorandumCategory').value = curriculum.memorandum_category;
                                memorandumCategorySelect.dispatchEvent(new Event('change'));
                                
                                if (curriculum.memorandum) {
                                    setTimeout(() => {
                                        document.getElementById('memorandum').value = curriculum.memorandum;
                                    }, 200);
                                }
                            }, 100);
                        } else if (curriculum.memorandum) {
                            setTimeout(() => {
                                document.getElementById('memorandum').value = curriculum.memorandum;
                            }, 100);
                        }
                    }
                    
                    // Generate semester inputs and populate if data exists
                    if (curriculum.year_level) {
                        generateSemesterInputs(curriculum.year_level);
                        
                        // Hide units container for Senior High, show for College
                        if (curriculum.year_level === 'Senior High') {
                            unitsContainer.classList.add('hidden');
                             // Hide Academic Year for Senior High
                            const academicYearContainer = document.getElementById('academicYearContainer');
                            const academicYearInput = document.getElementById('academicYear');
                            if(academicYearContainer) academicYearContainer.classList.add('hidden');
                            if(academicYearInput) academicYearInput.removeAttribute('required');
                             // Hide Expiration Date for Senior High
                            const expirationDateContainer = document.getElementById('expirationDateContainer');
                            if(expirationDateContainer) expirationDateContainer.classList.add('hidden');
                        } else {
                            // Show Academic Year
                            const academicYearContainer = document.getElementById('academicYearContainer');
                            const academicYearInput = document.getElementById('academicYear');
                            const expirationDateContainer = document.getElementById('expirationDateContainer');
                            if(academicYearContainer) academicYearContainer.classList.remove('hidden');
                            if(academicYearInput) academicYearInput.setAttribute('required', 'required');
                            // Show Expiration Date
                            if(expirationDateContainer) expirationDateContainer.classList.remove('hidden');
                            unitsContainer.classList.remove('hidden'); // Ensure units container is visible
                            
                            const semesterUnitsLabel = document.getElementById('semesterUnitsLabel');
                            semesterUnitsLabel.textContent = 'Semester Units';
                            
                            // Populate semester units if available
                            if (curriculum.semester_units) {
                                setTimeout(() => {
                                    curriculum.semester_units.forEach((units, index) => {
                                        const input = document.getElementById(`semester_${index}`);
                                        if (input) {
                                            input.value = units;
                                        }
                                    });
                                    calculateTotalUnits();
                                }, 100);
                            }
                        }
                    }
                } else {
                    modalTitle.textContent = 'Create New Curriculum';
                    modalSubTitle.textContent = 'Fill in the details below to add a new curriculum.';
                    submitButton.querySelector('span').textContent = 'Create';
                    curriculumIdField.value = '';
                    
                    // Reset custom dropdown display
                    curriculumSelectedText.textContent = 'Select Curriculum';
                    curriculumSelectedText.classList.remove('text-slate-700');
                    curriculumSelectedText.classList.add('text-slate-500');
                    
                    // Reset dynamic sections
                    memorandumContainer.classList.add('hidden');
                    yearContainer.classList.add('hidden');
                    categoryContainer.classList.add('hidden');
                    unitsContainer.classList.add('hidden');

                    // Reset Academic Year visibility
                    const academicYearContainer = document.getElementById('academicYearContainer');
                    const academicYearInput = document.getElementById('academicYear');
                    const expirationDateContainer = document.getElementById('expirationDateContainer');
                    if(academicYearContainer) academicYearContainer.classList.remove('hidden');
                    if(academicYearInput) academicYearInput.setAttribute('required', 'required');
                    if(expirationDateContainer) expirationDateContainer.classList.remove('hidden');
                    memorandumSelect.innerHTML = '<option value="" disabled selected>Select Memorandum</option>';
                    memorandumYearSelect.value = '';
                    memorandumCategorySelect.value = '';
                    semesterInputs.innerHTML = '';
                    totalUnitsDisplay.textContent = '0';
                    
                    // Ensure Program Code and Level are reset for new curriculum
                    const programCodeInput = document.getElementById('programCode');
                    const yearLevelSelect = document.getElementById('yearLevel');
                    if (programCodeInput) {
                        programCodeInput.value = '';
                        programCodeInput.setAttribute('readonly', 'readonly');
                    }
                    if (yearLevelSelect) {
                        yearLevelSelect.value = '';
                    }
                }
                addCurriculumModal.classList.remove('hidden');
                setTimeout(() => {
                    addCurriculumModal.classList.remove('opacity-0');
                    modalPanel.classList.remove('opacity-0', 'scale-95');
                }, 10);
            };

            const hideAddEditModal = () => {
                addCurriculumModal.classList.add('opacity-0');
                modalPanel.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    addCurriculumModal.classList.add('hidden');
                    
                    // Reset duplicate detection state
                    createAnotherMode = false;
                    matchingCurriculums = [];
                    duplicateAlert.classList.add('hidden');
                    browseCurriculumsDropdown.classList.add('hidden');
                    duplicateMemorandumAlert.classList.add('hidden');
                }, 300);
            };
            
            const handleFormSubmit = (e) => {
                e.preventDefault();
                console.log('Form submit event triggered');
                
                const performSubmit = async () => {
                    console.log('Perform submit function called');
                    const id = curriculumIdField.value;
                    const method = id ? 'PUT' : 'POST';
                    const url = id ? `/api/curriculums/${id}` : '/api/curriculums';
                    
                    const formData = new FormData(curriculumForm);
                    // Collect semester units
                    const semesterUnits = [];
                    document.querySelectorAll('.semester-unit-input').forEach(input => {
                        semesterUnits.push(parseFloat(input.value) || 0);
                    });
                    
                    const payload = {
                        curriculum: formData.get('curriculum'),
                        programCode: formData.get('programCode'),
                        academicYear: (formData.get('yearLevel') === 'Senior High' && !formData.get('academicYear')) ? 'N/A' : formData.get('academicYear'),
                        expirationDate: formData.get('expirationDate'),
                        yearLevel: formData.get('yearLevel'),
                        compliance: formData.get('compliance'),
                        memorandumYear: formData.get('memorandumYear'),
                        memorandumCategory: formData.get('memorandumCategory'),
                        memorandum: formData.get('memorandum'),
                        semesterUnits: semesterUnits,
                        totalUnits: parseFloat(totalUnitsDisplay.textContent) || 0
                    };
                    
                    try {
                        console.log('Submitting payload:', payload);
                        console.log('URL:', url);
                        console.log('Method:', method);
                        
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify(payload)
                        });
                        
                        if (!response.ok) {
                            const errorData = await response.json();
                            console.error('Server error response:', errorData);
                            console.error('Response status:', response.status);
                            throw errorData;
                        }
                        
                        const result = await response.json();
                        hideAddEditModal();
                        fetchCurriculums();
                        
                        // Use helper function to handle response
                        handleAjaxResponse(result, () => {
                            // Fallback notification if none provided by server
                            if (!result.notification) {
                                notificationManager.success(
                                    `Curriculum ${id ? 'Updated' : 'Created'}!`,
                                    `The curriculum has been successfully ${id ? 'updated' : 'created'}.`
                                );
                            }
                        });
                    } catch (error) {
                        console.error('Form submission error:', error);
                        handleAjaxError(error);
                    }
                };

                const isUpdating = !!curriculumIdField.value;
                const isRejectedUpdate = curriculumForm.dataset.approvalStatus === 'rejected';
                
                console.log('Showing confirmation modal, isUpdating:', isUpdating, 'isRejectedUpdate:', isRejectedUpdate);
                
                showConfirmationModal({
                    title: isRejectedUpdate ? 'Revise Rejected Curriculum?' : (isUpdating ? 'Update Curriculum?' : 'Create Curriculum?'),
                    message: isRejectedUpdate 
                        ? 'Are you sure you want to update this rejected curriculum? It will be returned to processing status for review.' 
                        : `Are you sure you want to ${isUpdating ? 'update' : 'create'} this curriculum?`,
                    icon: `<svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
                    confirmButtonClass: 'bg-blue-600 hover:bg-blue-700',
                    onConfirm: () => {
                        performSubmit().then(() => {
                            if (isRejectedUpdate) {
                                // Redirect to subject mapping after successful update of rejected curriculum
                                window.location.href = `/subject_mapping?curriculumId=${curriculumIdField.value}`;
                            }
                        });
                    }
                });
            };
            
            const attachActionListeners = () => {
                // Edit and delete functionality removed
            };

            const approvalFilter = document.getElementById('approval-filter');

            searchBar.addEventListener('input', (e) => {
                filterCurriculums();
            });

            versionFilter.addEventListener('change', (e) => {
                updateApprovalOptions();
                filterCurriculums();
            });

            approvalFilter.addEventListener('change', (e) => {
                filterCurriculums();
            });

            // Function to manage approval filter options
            function updateApprovalOptions() {
                const isOld = versionFilter.value === 'old';
                const options = approvalFilter.options;
                
                // Processing option (value="processing")
                // Rejected option (value="rejected")
                // Approved option (value="approved")
                // All Status option (value="all")

                for (let i = 0; i < options.length; i++) {
                    const opt = options[i];
                    if (isOld) {
                        // Hide Processing, Rejected, AND All Status for Old version
                        if (opt.value === 'processing' || opt.value === 'rejected' || opt.value === 'all') {
                            opt.hidden = true;
                            opt.style.display = 'none'; // Fallback for some browsers
                        } else {
                            opt.hidden = false;
                            opt.style.display = '';
                        }
                    } else {
                        // Restore all
                        opt.hidden = false;
                        opt.style.display = '';
                    }
                }

                // If Old, force selection to 'approved' since it's the only one visible
                if (isOld) {
                    approvalFilter.value = 'approved';
                }
            }

            function filterCurriculums() {
                const searchTerm = searchBar.value.toLowerCase();
                const versionStatus = versionFilter.value;
                const approvalStatus = approvalFilter.value;
                
                document.querySelectorAll('.curriculum-card').forEach(card => {
                    const name = card.dataset.name;
                    const code = card.dataset.code;
                    const version = card.dataset.version;
                    const approval = card.dataset.approvalStatus;
                    
                    const matchesSearch = name.includes(searchTerm) || code.includes(searchTerm);
                    const matchesVersion = version === versionStatus;
                    
                    // Safeguard: If Old version selected, strictly filter out non-approved if the user implies "only show approved"
                    // But if dropdown logic is correct, approvalStatus will be 'approved' or 'all'.
                    // If 'all', matchesApproval logic below is true for everything. 
                    // If we strictly want ONLY approved for Old, we can add:
                    // if (versionStatus === 'old' && approvalStatus === 'all') matchesApproval = approval === 'approved'; (Assuming Old => Approved)
                    // Let's rely on standard filtering, but ensure dropdown state is correct.
                    
                    const matchesApproval = approvalStatus === 'all' || approval === approvalStatus;
                    
                    card.style.display = (matchesSearch && matchesVersion && matchesApproval) ? 'flex' : 'none';
                });
            }

            // Initial call to set up correct options state based on default selection
            updateApprovalOptions();

            addCurriculumButton.addEventListener('click', () => showAddEditModal());
            closeModalButton.addEventListener('click', hideAddEditModal);
            cancelModalButton.addEventListener('click', hideAddEditModal);
            curriculumForm.addEventListener('submit', handleFormSubmit);

            // Global functions for approve/reject (accessible from onclick)
            window.approveCurriculum = async (curriculumId) => {
                showConfirmationModal({
                    title: 'Approve Curriculum?',
                    message: 'Are you sure you want to approve this curriculum?',
                    icon: `<svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
                    confirmButtonClass: 'bg-green-600 hover:bg-green-700',
                    onConfirm: async () => {
                        try {
                            const response = await fetch(`/api/curriculums/${curriculumId}/approve`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json',
                                }
                            });

                            if (!response.ok) {
                                throw new Error('Failed to approve curriculum');
                            }

                            const result = await response.json();
                            
                            // Show success notification
                            if (result.notification) {
                                showSuccessModal(result.notification.title, result.notification.message);
                            }
                            
                            // Refresh the curriculum list
                            fetchCurriculums();
                        } catch (error) {
                            console.error('Error approving curriculum:', error);
                            showSuccessModal('Error', 'Failed to approve curriculum. Please try again.');
                        }
                    }
                });
            };

            window.rejectCurriculum = async (curriculumId) => {
                showConfirmationModal({
                    title: 'Reject Curriculum?',
                    message: 'Are you sure you want to reject this curriculum?',
                    icon: '<svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" /></svg>',
                    confirmButtonClass: 'bg-red-600 hover:bg-red-700',
                    onConfirm: async () => {
                        try {
                            const response = await fetch(`/api/curriculums/${curriculumId}/reject`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                }
                            });

                            const data = await response.json();

                            if (response.ok) {
                                showSuccessModal('Curriculum Rejected!', data.message);
                                fetchCurriculums(); // Changed from fetchAndDisplayCurriculums()
                            } else {
                                alert('Error: ' + (data.message || 'Failed to reject curriculum'));
                            }
                        } catch (error) {
                            console.error('Error rejecting curriculum:', error);
                            showSuccessModal('Error', 'Failed to reject curriculum. Please try again.'); // Reverted to original error handling
                        }
                    }
                });
            };



            window.handleCardClick = (id, status) => {
                if (status === 'approved') return;
                
                if (status === 'rejected') {
                    console.log('Clicked rejected curriculum with ID:', id);
                    console.log('Available curriculums:', window.curriculumsData);
                    
                    if (!window.curriculumsData) {
                        console.error('Curriculums data not loaded yet');
                        return;
                    }
                    
                    const curriculum = window.curriculumsData.find(c => c.id === id);
                    console.log('Found curriculum:', curriculum);
                    
                    if (curriculum) {
                        openRejectedCurriculumModal(curriculum);
                    } else {
                        console.error('Curriculum not found with ID:', id);
                    }
                } else {
                    window.location.href = '/subject_mapping?curriculumId=' + id;
                }
            };

            window.openRejectedCurriculumModal = (curriculum) => {
                console.log('Opening rejected curriculum modal with data:', curriculum);
                console.log('Curriculum name:', curriculum.curriculum_name, 'Curriculum:', curriculum.curriculum);
                showAddEditModal(true, curriculum);
                
                // Change modal title to indicate this is for revising a rejected curriculum
                document.getElementById('modal-title').textContent = 'Revise Rejected Curriculum';
                document.querySelector('#modal-panel > div.text-center.mb-8 > p').textContent = 'Update and fix the issues for this rejected curriculum.';
                
                // Allow full editing - no fields are read-only
                // The curriculum can be fully edited and will return to "processing" status when saved
                
                // Set status for submit handler
                curriculumForm.dataset.approvalStatus = 'rejected';
            };

            // --- Program Modal Functions ---
            const openProgramModal = () => {
                addProgramModal.classList.remove('hidden');
                setTimeout(() => {
                    programModalPanel.classList.remove('opacity-0', 'scale-95');
                    programModalPanel.classList.add('opacity-100', 'scale-100');
                }, 10);
            };

            const closeProgramModal = () => {
                programModalPanel.classList.remove('opacity-100', 'scale-100');
                programModalPanel.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    addProgramModal.classList.add('hidden');
                    programForm.reset();
                }, 300);
            };

            addNewProgramButton.addEventListener('click', openProgramModal);
            closeProgramModalButton.addEventListener('click', closeProgramModal);
            cancelProgramButton.addEventListener('click', closeProgramModal);

            // Close modal when clicking outside
            addProgramModal.addEventListener('click', (e) => {
                if (e.target === addProgramModal) {
                    closeProgramModal();
                }
            });

            programForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                
                const formData = new FormData(programForm);
                const data = Object.fromEntries(formData.entries());

                try {
                    const response = await fetch('/api/programs', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (response.ok) {
                        // Add new option to the hidden select dropdown
                        const optGroupLabel = data.department;
                        let optGroup = Array.from(curriculumInput.getElementsByTagName('optgroup'))
                                           .find(group => group.label === optGroupLabel);
                        
                        // If optgroup doesn't exist, create it
                        if (!optGroup) {
                            optGroup = document.createElement('optgroup');
                            optGroup.label = optGroupLabel;
                            curriculumInput.appendChild(optGroup);
                        }

                        const option = document.createElement('option');
                        option.value = result.program.description;
                        option.dataset.code = result.program.code;
                        option.textContent = result.program.description;
                        
                        optGroup.appendChild(option);
                        
                        // Add new option to the custom dropdown UI
                        const groupLabel = data.department;
                        let customGroup = Array.from(curriculumOptionsList.querySelectorAll('.curriculum-group'))
                                               .find(group => group.querySelector('div').textContent === groupLabel);
                        
                        if (customGroup) {
                            const newOption = document.createElement('div');
                            newOption.className = 'curriculum-option px-3 py-2 hover:bg-blue-50 cursor-pointer transition-colors';
                            newOption.dataset.value = result.program.description;
                            newOption.dataset.code = result.program.code;
                            newOption.dataset.department = data.department;
                            newOption.innerHTML = `<div class="text-sm text-slate-700">${result.program.description}</div>`;
                            customGroup.appendChild(newOption);
                        }
                        
                        // Select the new option
                        curriculumInput.value = result.program.description;
                        curriculumSelectedText.textContent = result.program.description;
                        curriculumSelectedText.classList.remove('text-slate-500');
                        curriculumSelectedText.classList.add('text-slate-700');
                        
                        // Trigger change event to populate other fields
                        curriculumInput.dispatchEvent(new Event('change'));

                        showSuccessModal('Program Added', 'The new curriculum name has been added successfully.');
                        closeProgramModal();
                    } else {
                         alert(result.message || 'Error creating program.');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('An unexpected error occurred.');
                }
            });

            fetchCurriculums();
        });
    </script>
@endsection