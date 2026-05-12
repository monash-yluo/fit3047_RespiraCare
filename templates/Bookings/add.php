<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var \Cake\Collection\CollectionInterface|string[] $patients
 * @var \Cake\Collection\CollectionInterface|string[] $clinicians
 * @var $identity
 */

// Breadcrumb
$booking_url = null;

if ($identity->role === 'admin') {
    $booking_url = ['controller' => 'Bookings', 'action' => 'index'];
} else {
    $booking_url = ['controller' => 'Bookings', 'action' => 'patientClinicianIndex'];
}

$breadcrumbs = [
    ['title' => 'Bookings', 'url' => $booking_url],
    ['title' => 'Request New Booking', 'url' => null],
];

$this->setLayout($identity->role);
$this->assign('title', 'Request New Booking');
?>

<?= $this->Html->css(
    'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
    ['block' => 'css'],
) ?>

<?= $this->Html->script(
    'https://cdn.jsdelivr.net/npm/flatpickr',
    ['block' => 'script'],
) ?>

<div class="px-4 pt-6">

    <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

    <?= $this->element('table/page_header', [
        'title' => 'Request Appointment',
        'description' => 'Please select a clinician and your preferred appointment date and time.',
        'showBack' => true,
    ]) ?>

    <?= $this->Form->create($booking) ?>

    <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Booking Details</h3>

                <div class="grid grid-cols-1 gap-x-4 gap-y-6">
                    <?php if ($identity->role === 'admin') : ?>
                        <div>
                            <label for="patient_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Patient</label>
                            <?= $this->Form->control('patient_id', [
                                'type' => 'select',
                                'options' => $patients ?? [],
                                'label' => false,
                                'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                            ]) ?>
                        </div>
                    <?php endif; ?>

                    <div>
                        <label for="clinician_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Clinician</label>
                        <?= $this->Form->control('clinician_id', [
                            'id' => 'clinician-id',
                            'type' => 'select',
                            'options' => $clinicians,
                            'label' => false,
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        ]) ?>
                    </div>

                    <div>
                        <label for="scheduled_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preferred Appointment Date & Time</label>
                        <?= $this->Form->control('scheduled_date', [
                            'type' => 'datetime-local',
                            'id' => 'scheduled_date',
                            'label' => false,
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5',
                            'min' => date('Y-m-d\TH:i'),
                        ]) ?>
                    </div>

                    <div>
                        <label for="duration" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Duration</label>
                        <?= $this->Form->control('duration', [
                            'type' => 'select',
                            'options' => [
                                30 => '30 Minutes',
                                45 => '45 Minutes',
                                60 => '1 Hour',
                                90 => '1 Hours & 30 Minutes',
                            ],
                            'default' => 30, // Sets a sensible default
                            'label' => false,
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        ]) ?>
                    </div>

                    <?php if ($identity->role === 'admin') : ?>
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                        <?= $this->Form->control('status', [
                            'type' => 'select',
                            'options' => [
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'declined' => 'Declined',
                            ],
                            'label' => false,
                            'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400',
                        ]) ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="xl:col-span-1">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-lg font-semibold dark:text-white">Note</h3>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Write a note</label>
                    <?= $this->Form->textarea('notes', [
                        'rows' => 4,
                        'placeholder' => 'Any additional information or requests...',
                        'class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 placeholder-gray-400'
                    ]) ?>
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700 my-4">

            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="flex flex-col space-y-4">
                    <?= $this->element('button/blue_button', ['label' => 'Request Booking', 'type' => 'submit']) ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<?php $this->append('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clinicianSelect = document.getElementById('clinician-id');
        const dateInput = document.getElementById('scheduled_date');
        const durationSelect = document.getElementById('duration');

        let blockedSlots = [];

        function fetchAvailability(clinicianId) {
            if (!clinicianId) return;

            fetch(`/bookings/get-booked-slots/${clinicianId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => response.json())
                .then(data => {
                    blockedSlots = data.blocked || [];
                    validateDate();
                })
                .catch(error => console.error('Error fetching availability:', error));
        }

        // 2. The Validation Function
        function validateDate() {
            if (!dateInput.value) return;

            const selected = new Date(dateInput.value);

            const hours = selected.getHours();
            if (hours < 9 || hours >= 17) {
                alert('Please select a time during clinic hours (9:00 AM - 5:00 PM).');
                dateInput.value = '';
                return;
            }

            let newStart = selected.getTime();
            let durationMins = durationSelect ? parseInt(durationSelect.value) : 30;
            let newEnd = newStart + (durationMins * 60000);

            for (let i = 0; i < blockedSlots.length; i++) {
                // Safari-safe date parsing
                let slotFrom = new Date(blockedSlots[i].from.replace(/-/g, '/')).getTime();
                let slotTo = new Date(blockedSlots[i].to.replace(/-/g, '/')).getTime();

                // Overlap formula
                if (newStart < slotTo && newEnd > slotFrom) {
                    alert("This time overlaps with an existing appointment! Please choose another time.");
                    dateInput.value = '';
                    return;
                }
            }
        }

        // 3. Attach Event Listeners
        dateInput.addEventListener('change', validateDate);

        if (durationSelect) {
            durationSelect.addEventListener('change', validateDate);
        }

        // Listen for clinician changes
        document.body.addEventListener('change', function(e) {
            if (e.target && e.target.id === 'clinician-id') {
                fetchAvailability(e.target.value);
            }
        });

        // Trigger fetch on load if editing/refreshing
        if (clinicianSelect && clinicianSelect.value) {
            fetchAvailability(clinicianSelect.value);
        }
    });
</script>
<?php $this->end(); ?>
