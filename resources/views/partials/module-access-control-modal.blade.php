<!-- Module Access Control Section for Modal -->
<div>
    <label class="block text-sm font-medium text-slate-700 mb-2">Module Access Permissions</label>
    <div class="bg-slate-50 border border-slate-300 rounded-lg p-3 max-h-48 overflow-y-auto">
        <div class="grid grid-cols-2 gap-2">
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-blue-100 border border-blue-400 rounded cursor-pointer">
                <input type="checkbox" name="modules[]" value="dashboard" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)" checked>
                <span class="text-xs text-gray-700">Dashboard</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="official_curriculum" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Official Curriculum</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="curriculum_builder" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Curriculum Builder</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="subject_mapping" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Subject Mapping</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="pre_requisite" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Pre-requisite</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="compliance_validator" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Compliance Validator</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="course_builder" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Course Builder</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="grade_setup" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Grade Setup</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="equivalency_tool" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Equivalency Tool</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="mapping_history" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Mapping History</span>
            </label>
            <label class="modal-module-label flex items-center space-x-2 p-2 bg-white border border-slate-200 rounded hover:bg-blue-50 cursor-pointer">
                <input type="checkbox" name="modules[]" value="curriculum_export_tool" class="modal-module-checkbox w-4 h-4 text-blue-600 rounded" onchange="updateModalModuleStyle(this)">
                <span class="text-xs text-gray-700">Curriculum Export Tool</span>
            </label>
        </div>
        <p class="text-xs text-slate-600 mt-2">Select which modules this employee can access.</p>

        <script>
            function updateModalModuleStyle(checkbox) {
                const label = checkbox.closest('.modal-module-label');
                if (checkbox.checked) {
                    label.classList.remove('bg-white', 'border-slate-200');
                    label.classList.add('bg-blue-100', 'border-blue-400');
                } else {
                    label.classList.remove('bg-blue-100', 'border-blue-400');
                    label.classList.add('bg-white', 'border-slate-200');
                }
            }

            // Initialize colors on page load for modal
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.modal-module-checkbox').forEach(function(checkbox) {
                    updateModalModuleStyle(checkbox);
                });
            });
        </script>
    </div>
</div>
