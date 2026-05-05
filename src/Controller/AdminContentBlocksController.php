<?php
declare(strict_types=1);

namespace App\Controller;

use ContentBlocks\Controller\ContentBlocksController as BaseContentBlocksController;
use Cake\Event\EventInterface;

class AdminContentBlocksController extends BaseContentBlocksController
{
    public function initialize(): void
    {
        parent::initialize();
        
        // 手动设置 ContentBlocks 模型
        $this->ContentBlocks = $this->fetchTable('ContentBlocks.ContentBlocks');
    }
    
    /**
     * Before filter handler.
     * 这里同时执行 AppController 和插件的 beforeFilter
     *
     * @param \Cake\Event\EventInterface $event The event.
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        // 首先执行 AppController 的 beforeFilter（你自定义的方法）
        // 获取 AppController 的 beforeFilter 方法并执行
        $appControllerMethod = new \ReflectionMethod(AppController::class, 'beforeFilter');
        $appControllerMethod->invoke($this, $event);
        
        // 然后执行插件的 beforeFilter（处理 ContentBlocks 特定的逻辑）
        parent::beforeFilter($event);

        // 最后执行权限检查，确保只有管理员可以访问
        $this->checkRole(['admin']);
    }
}
