<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\HasDatabaseNotifications;


class Notifications extends Page
{

    protected static ?string $navigationIcon = 'heroicon-o-bell';
    protected static ?string $navigationGroup = 'User Notifications';
    protected static ?string $navigationLabel = 'Notifications';

    public function getViewData(): array
    {
        return [
            'notifications' => DatabaseNotification::where('notifiable_type', 'App\Models\User')
                ->where('notifiable_id', auth()->id())
                ->latest()
                ->paginate(10),
        ];
    }

    public function markAllAsRead()
    {
        DatabaseNotification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        $this->notify('success', 'All notifications have been marked as read.');
    }

    public function deleteNotification($notificationId)
    {
        $notification = DatabaseNotification::where('notifiable_type', 'App\Models\User')
            ->where('notifiable_id', auth()->id())
            ->where('id', $notificationId)
            ->first();

        if ($notification) {
            $notification->delete();
            $this->notify('success', 'Notification deleted successfully.');
        }
    }


    protected static string $view = 'filament.pages.notifications';
}
