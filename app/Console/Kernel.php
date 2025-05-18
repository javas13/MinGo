<?php
protected function schedule(Schedule $schedule): void
{
    // Пусто - все задачи теперь в routes/console.php
}

protected function commands(): void
{
    $this->load(__DIR__.'/Commands');
    require base_path('routes/console.php');
}