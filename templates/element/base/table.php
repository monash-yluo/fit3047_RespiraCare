<?php
/**
 * Generic Admin Table Element (Variable Version)
 * @var \Cake\View\View $this
 * @var iterable $data 分页数据集合
 * @var string $headers 传入的表头 HTML 字符串
 * @var string $rows 传入的行数据 HTML 字符串
 * @var string $emptyMessage 数据为空时的提示
 *
 * AI 提取的, 但好像用不了
 */
?>
<div class="flex flex-col">
    <div class="overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-hidden shadow">
                <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <?= $headers ?>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    <?php if ($data->isEmpty()): ?>
                        <tr>
                            <td colspan="20" class="p-8 text-center text-gray-500 dark:text-gray-400 bg-gray-50 dark:bg-gray-800">
                                <p class="text-lg font-medium text-gray-900 dark:text-white"><?= h($emptyMessage ?? 'No records found') ?></p>
                            </td>
                        </tr>
                    <?php else : ?>
                        <?= $rows ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div
    class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200
        sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">

    <div class="flex items-center mb-4 sm:mb-0">
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                <?= $this->Paginator->counter(__('Showing {{start}}-{{end}} of {{count}}')) ?>
            </span>
    </div>

    <div class="flex items-center space-x-3">
        <ul class="pagination">
            <?= $this->Paginator->prev('< Previous')?>
            <?= $this->Paginator->next('Next >') ?>
        </ul>
    </div>
</div>
