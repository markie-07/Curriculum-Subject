<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModuleAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Unauthorized action.');
        }

        // Super Admin bypass this check
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check for specific module access
        if ($user->hasModuleAccess($module)) {
            return $next($request);
        }

        abort(403, 'Access Denied: You do not have permission to access the ' . $this->getModuleName($module) . ' module.');
    }

    /**
     * Get readable module name
     */
    private function getModuleName($key)
    {
        $names = [
            'dashboard' => 'Dashboard',
            'employees' => 'Employee Management',
            'official_curriculum' => 'Official Curriculum',
            'curriculum_builder' => 'Curriculum Builder',
            'subject_mapping' => 'Subject Mapping',
            'pre_requisite' => 'Pre-requisite',
            'compliance_validator' => 'Compliance Validator',
            'course_builder' => 'Course Builder',
            'grade_setup' => 'Grade Setup',
            'equivalency_tool' => 'Equivalency Tool',
            'mapping_history' => 'Mapping History',
            'curriculum_export_tool' => 'Curriculum Export Tool',
        ];

        return $names[$key] ?? ucwords(str_replace('_', ' ', $key));
    }
}
