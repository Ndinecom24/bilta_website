<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class ShowTrainingCenter extends Component
{
    public $activeSection = 'getting-started';

    public function setSection($section)
    {
        $this->activeSection = $section;
    }

    public function render()
    {
        $sections = $this->getTrainingSections();

        return view('livewire.admin.training-center', compact('sections'));
    }

    private function getTrainingSections(): array
    {
        return [
            'getting-started' => [
                'icon' => 'fas fa-rocket',
                'title' => 'Getting Started',
                'color' => '#2563eb',
            ],
            'dashboard' => [
                'icon' => 'fas fa-tachometer-alt',
                'title' => 'Dashboard Overview',
                'color' => '#1d4ed8',
            ],
            'content-management' => [
                'icon' => 'fas fa-edit',
                'title' => 'Content Management',
                'color' => '#059669',
            ],
            'announcements' => [
                'icon' => 'fas fa-bullhorn',
                'title' => 'Announcements & Memos',
                'color' => '#ea580c',
            ],
            'documents' => [
                'icon' => 'fas fa-folder-open',
                'title' => 'Document Repository',
                'color' => '#0d9488',
            ],
            'newsletters-enquiries' => [
                'icon' => 'fas fa-envelope-open-text',
                'title' => 'Newsletters & Enquiries',
                'color' => '#7c3aed',
            ],
            'leave-application' => [
                'icon' => 'fas fa-calendar-check',
                'title' => 'Applying for Leave',
                'color' => '#d97706',
            ],
            'leave-approval' => [
                'icon' => 'fas fa-check-double',
                'title' => 'Approving Leave',
                'color' => '#dc2626',
            ],
            'leave-management' => [
                'icon' => 'fas fa-cogs',
                'title' => 'Leave Admin Setup',
                'color' => '#0891b2',
            ],
            'departments' => [
                'icon' => 'fas fa-building',
                'title' => 'Departments',
                'color' => '#4f46e5',
            ],
            'positions' => [
                'icon' => 'fas fa-id-badge',
                'title' => 'Positions',
                'color' => '#0284c7',
            ],
            'user-management' => [
                'icon' => 'fas fa-users-cog',
                'title' => 'User Accounts',
                'color' => '#be185d',
            ],
            'roles-permissions' => [
                'icon' => 'fas fa-shield-alt',
                'title' => 'Roles & Permissions',
                'color' => '#b45309',
            ],
            'analytics' => [
                'icon' => 'fas fa-chart-bar',
                'title' => 'Analytics',
                'color' => '#6366f1',
            ],
            'faq' => [
                'icon' => 'fas fa-question-circle',
                'title' => 'FAQ & Troubleshooting',
                'color' => '#64748b',
            ],
        ];
    }
}
