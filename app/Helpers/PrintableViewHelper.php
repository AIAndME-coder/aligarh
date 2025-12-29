<?php

namespace App\Helpers;

use Illuminate\Support\Facades\View;

class PrintableViewHelper
{
    /**
     * Resolve printable view path with tenant-specific override support.
     * Checks for tenant-specific printable first, falls back to default.
     *
     * @param string $viewName The view name without 'admin.printable.' prefix
     * @return string The resolved view path
     * @example PrintableViewHelper::resolve('exam_transcript')
     */
    public static function resolve($viewName)
    {
        $tenantId = tenancy()->tenant->id;
        $tenantPath = "admin.printable.{$tenantId}.{$viewName}";
        $defaultPath = "admin.printable.{$viewName}";
        
        // Check if tenant-specific view exists
        if (View::exists($tenantPath)) {
            return $tenantPath;
        }
        
        // Fall back to default
        return $defaultPath;
    }
}
