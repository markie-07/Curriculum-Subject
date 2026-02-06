<!-- Module Access Control Section -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-3">
        Module Access Permissions <span class="text-gray-500">(Select modules this employee can access)</span>
    </label>
    <div class="bg-gray-50 border border-gray-300 rounded-lg p-4 space-y-3">
        @php
            $availableModules = [
                'dashboard' => [
                    'name' => 'Dashboard', 
                    'description' => 'View system overview, key statistics, and recent activities.',
                    'color' => 'from-purple-500 to-pink-500', 
                    'text' => 'text-purple-600', 
                    'bg' => 'bg-purple-100', 
                    'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'
                ],
                'official_curriculum' => [
                    'name' => 'Official Curriculum', 
                    'description' => 'Manage and view standardized curriculum data and records.',
                    'color' => 'from-blue-500 to-cyan-500', 
                    'text' => 'text-blue-600', 
                    'bg' => 'bg-blue-100', 
                    'icon' => 'M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z'
                ],
                'curriculum_builder' => [
                    'name' => 'Curriculum Builder', 
                    'description' => 'Create, edit, and structure curriculum versions.',
                    'color' => 'from-green-500 to-emerald-500', 
                    'text' => 'text-green-600', 
                    'bg' => 'bg-green-100', 
                    'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'
                ],
                'subject_mapping' => [
                    'name' => 'Subject Mapping', 
                    'description' => 'Map subjects across different curriculum years and versions.',
                    'color' => 'from-orange-500 to-red-500', 
                    'text' => 'text-orange-600', 
                    'bg' => 'bg-orange-100', 
                    'icon' => 'M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'
                ],
                'pre_requisite' => [
                    'name' => 'Pre-requisite', 
                    'description' => 'Set up and manage subject pre-requisites and co-requisites.',
                    'color' => 'from-indigo-500 to-purple-500', 
                    'text' => 'text-indigo-600', 
                    'bg' => 'bg-indigo-100', 
                    'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'
                ],
                'compliance_validator' => [
                    'name' => 'Compliance Validator', 
                    'description' => 'Validate curriculum structure against CHED standards.',
                    'color' => 'from-teal-500 to-green-500', 
                    'text' => 'text-teal-600', 
                    'bg' => 'bg-teal-100', 
                    'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'
                ],
                'course_builder' => [
                    'name' => 'Course Builder', 
                    'description' => 'Manage course offerings, codes, and descriptive titles.',
                    'color' => 'from-yellow-500 to-orange-500', 
                    'text' => 'text-yellow-600', 
                    'bg' => 'bg-yellow-100', 
                    'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'
                ],
                'grade_setup' => [
                    'name' => 'Grade Weighting Setup', 
                    'description' => 'Configure grading systems, weights, and computation rules.',
                    'color' => 'from-pink-500 to-rose-500', 
                    'text' => 'text-pink-600', 
                    'bg' => 'bg-pink-100', 
                    'icon' => 'M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z'
                ],
                'equivalency_tool' => [
                    'name' => 'Subject Equivalency Tool', 
                    'description' => 'Manage internal and external subject equivalencies.',
                    'color' => 'from-cyan-500 to-blue-500', 
                    'text' => 'text-cyan-600', 
                    'bg' => 'bg-cyan-100', 
                    'icon' => 'M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4'
                ],
                'mapping_history' => [
                    'name' => 'Mapping History', 
                    'description' => 'View historical logs of subject mapping changes.',
                    'color' => 'from-violet-500 to-purple-500', 
                    'text' => 'text-violet-600', 
                    'bg' => 'bg-violet-100', 
                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                ],
                'curriculum_export_tool' => [
                    'name' => 'Curriculum Export Tool', 
                    'description' => 'Export curriculum data to PDF, Excel, and other formats.',
                    'color' => 'from-emerald-500 to-teal-500', 
                    'text' => 'text-emerald-600', 
                    'bg' => 'bg-emerald-100', 
                    'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'
                ],
            ];
            
            // Get selected modules and ensure it's an array
            $selectedModules = old('modules');

            if ($selectedModules === null) {
                if (isset($employee) && $employee->modules) {
                    $modules = $employee->modules;
                    if (is_string($modules)) {
                        $selectedModules = json_decode($modules, true) ?? [];
                    } else {
                        $selectedModules = $modules;
                    }
                } else {
                    // Default for new employees: Dashboard access
                    $selectedModules = isset($employee) ? [] : ['dashboard'];
                }
            }
            
            $selectedModules = is_array($selectedModules) ? $selectedModules : [];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 h-full">
            <!-- Left Column: Module Selection -->
            <div class="lg:col-span-2 bg-gray-50 border border-gray-200 rounded-xl p-6 flex flex-col h-full">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 flex-grow">
                    {{-- Admin / Select All Box --}}
                    <label class="module-checkbox-label group relative overflow-hidden flex flex-col items-center justify-center py-8 px-4 h-full min-h-[160px] bg-white border-2 border-slate-200 rounded-2xl cursor-pointer transition-all duration-300 hover:shadow-lg hover:border-slate-400 hover:-translate-y-1" data-module="admin-select">
                        <input type="checkbox" 
                               id="select-all-modules"
                               class="module-checkbox peer sr-only"
                               onchange="toggleAllModules(this)">
                        
                        <!-- Gradient Background -->
                        <div class="absolute inset-0 bg-gradient-to-br from-slate-700 to-slate-900 opacity-0 peer-checked:opacity-10 transition-opacity duration-300"></div>
                        
                        <!-- Content -->
                        <div class="relative z-10 flex flex-col items-center text-center space-y-4 w-full">
                            <!-- Icon Circle -->
                            <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center transition-all duration-300 peer-checked:bg-slate-800 peer-checked:scale-110 peer-checked:shadow-md">
                                <svg class="w-7 h-7 text-slate-500 peer-checked:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            
                            <!-- Text -->
                            <div class="flex-1 w-full flex items-center justify-center">
                                <span class="text-sm font-extrabold text-slate-700 peer-checked:text-slate-900 transition-all duration-200 uppercase tracking-wide leading-tight">FULL ACCESS (ADMIN)</span>
                            </div>
                            
                            <!-- Checkmark Badge -->
                            <div class="absolute top-0 right-0 opacity-0 peer-checked:opacity-100 transition-all duration-300 scale-0 peer-checked:scale-100 transform translate-x-2 -translate-y-2">
                                <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center shadow-md">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Active Border -->
                        <div class="absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-slate-800 opacity-0 peer-checked:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                    </label>

                    @foreach($availableModules as $key => $module)
                        <label class="module-checkbox-label group relative overflow-hidden flex flex-col items-center justify-center py-8 px-4 h-full min-h-[160px] bg-white border-2 border-slate-100 rounded-2xl cursor-pointer transition-all duration-300 hover:shadow-lg hover:border-slate-300 hover:-translate-y-1" data-module="{{ $key }}">
                            <input type="checkbox" 
                                   name="modules[]" 
                                   value="{{ $key }}"
                                   {{ in_array($key, $selectedModules) ? 'checked' : '' }}
                                   class="module-checkbox peer sr-only"
                                   onchange="updateModuleStyle(this)">
                            
                            <!-- Gradient Background (shown when checked) -->
                            <div class="absolute inset-0 bg-gradient-to-br {{ $module['color'] }} opacity-0 peer-checked:opacity-10 transition-opacity duration-300"></div>
                            
                            <!-- Content -->
                            <div class="relative z-10 flex flex-col items-center text-center space-y-4 w-full">
                                <!-- Icon Circle -->
                                <div class="flex-shrink-0 w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center transition-all duration-300 peer-checked:{{ $module['bg'] }} peer-checked:scale-110 peer-checked:shadow-sm">
                                    <svg class="w-7 h-7 text-slate-400 peer-checked:{{ $module['text'] }} transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $module['icon'] }}"></path>
                                    </svg>
                                </div>
                                
                                <!-- Text -->
                                <div class="flex-1 w-full flex items-center justify-center">
                                    <span class="text-sm font-bold text-slate-600 peer-checked:text-gray-900 transition-all duration-200 uppercase tracking-wide leading-tight">{{ $module['name'] }}</span>
                                </div>
                                
                                <!-- Checkmark Badge (Absolute Positioned) -->
                                <div class="absolute top-0 right-0 opacity-0 peer-checked:opacity-100 transition-all duration-300 scale-0 peer-checked:scale-100 transform translate-x-2 -translate-y-2">
                                    <div class="w-8 h-8 rounded-full {{ $module['bg'] }} flex items-center justify-center shadow-md">
                                        <svg class="w-4 h-4 {{ $module['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Active Border -->
                            <div class="absolute inset-0 rounded-2xl border-2 border-transparent peer-checked:border-current {{ $module['text'] }} opacity-0 peer-checked:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Right Column: Info Box -->
            <div class="lg:col-span-1">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 h-full max-h-[800px] overflow-y-auto custom-scrollbar">
                    <style>
                        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
                        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
                        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
                        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
                    </style>
                    <div class="flex items-center space-x-2 mb-4 sticky top-0 bg-blue-50 pt-1 pb-2 z-10 border-b border-blue-100">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-blue-900">Module Access</h3>
                    </div>
                    
                    <div class="text-sm text-blue-800 space-y-4">
                        <p>Select which modules this employee can access.</p>
                        
                        <div class="pt-2">
                            <div class="flex items-start space-x-3 mb-4 p-2 bg-slate-100 rounded-lg border border-slate-200">
                                <span class="flex-shrink-0 w-3 h-3 mt-1.5 rounded-full bg-slate-800 shadow-sm"></span>
                                <div>
                                    <p class="font-bold text-slate-800 text-xs uppercase">Admin (Full Access)</p>
                                    <p class="text-xs text-slate-600 mt-0.5">Grants full access to all modules instantly.</p>
                                </div>
                            </div>

                            <p class="font-medium mb-3 text-blue-900">Module Legend:</p>
                            <div class="space-y-3">
                                @foreach($availableModules as $module)
                                <div class="flex items-start space-x-3 group">
                                    <div class="flex-shrink-0 w-3 h-3 mt-1.5 rounded-full bg-gradient-to-br {{ $module['color'] }} shadow-sm group-hover:scale-125 transition-transform duration-200"></div>
                                    <div>
                                        <p class="font-semibold text-gray-800 text-xs">{{ $module['name'] }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ $module['description'] }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function toggleAllModules(source) {
                const checkboxes = document.querySelectorAll('input[name="modules[]"]:not(#select-all-modules)');
                checkboxes.forEach(cb => {
                    cb.checked = source.checked;
                    // Trigger change event if needed for any attached listeners, though peer classes handle styles automatically
                    cb.dispatchEvent(new Event('change'));
                });
            }

            function updateModuleStyle(checkbox) {
                // The styling is handled by Tailwind's peer classes, so we don't need to do anything here
                // But we keep the function for compatibility if called
            }

            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Check if all are selected to set Admin box state? 
                // Optional: we can add logic here to check the admin box if all modules are already selected
                const checkboxes = document.querySelectorAll('input[name="modules[]"]:not(#select-all-modules)');
                const allChecked = Array.from(checkboxes).every(cb => cb.checked) && checkboxes.length > 0;
                const adminBox = document.getElementById('select-all-modules');
                if(adminBox && allChecked) {
                    adminBox.checked = true;
                }
            });
        </script>
