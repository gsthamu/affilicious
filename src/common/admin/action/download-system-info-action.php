<?php
namespace Affilicious\Common\Admin\Action;

use Affilicious\Common\Admin\System\System_Info;

if (!defined('ABSPATH')) {
    exit('Not allowed to access pages directly.');
}

class Download_System_Info_Action
{
    const ACTION = 'aff_download_system_info';
    const FILENAME = 'affilicious-system-info.txt';

    /**
     * @var System_Info
     */
    protected $system_info;

    /**
     * @since 0.9.18
     * @param System_Info $system_info
     */
    public function __construct(System_Info $system_info)
    {
        $this->system_info = $system_info;
    }

    /**
     * Handle the system info download.
     *
     * @hook admin_action_aff_download_system_info
     * @since 0.9.18
     */
    public function handle()
    {
        $action = filter_input(INPUT_GET, 'action');
        $nonce  = filter_input(INPUT_GET, 'nonce');

        if ($action === self::ACTION && wp_verify_nonce($nonce, self::ACTION)) {
            $this->download_system_info();
        }

        die();
    }

    /**
     * Create the download system info txt.
     *
     * @since 0.9.18
     */
    protected function download_system_info()
    {
        $text = $this->system_info->stringify();

        header('Content-type: text/plain');
        header(sprintf('Content-Disposition: attachment; filename="%s"', self::FILENAME));

        echo $text;
    }
}
