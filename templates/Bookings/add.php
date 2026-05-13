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

    <div class="px-4 pt-6">

        <?= $this->element('admin/breadcrumb', ['breadcrumbs' => $breadcrumbs]); ?>

        <?= $this->element('table/page_header', [
            'title' => 'Request Appointment',
            'description' => 'Please select a clinician, then choose your preferred date and time.',
            'showBack' => true,
        ]) ?>

        <?= $this->Form->create($booking, ['id' => 'booking-form']) ?>

        <!-- Hidden input that actually stores the final DateTime for CakePHP -->
        <?= $this->Form->hidden('scheduled_date', ['id' => 'scheduled_date_hidden']) ?>

        <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
            <div class="xl:col-span-2">
                <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <h3 class="mb-4 text-lg font-semibold dark:text-white">1. Practitioner Details</h3>

                    <div class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <?php if ($identity->role === 'admin') : ?>
                            <div class="sm:col-span-2">
                                <label for="patient_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Patient</label>
                                <?= $this->Form->control('patient_id', [
                                    'type' => 'select',
                                    'options' => $patients ?? [],
                                    'label' => false,
                                    'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                                ]) ?>
                            </div>
                        <?php endif; ?>

                        <div>
                            <label for="clinician_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select Clinician</label>
                            <?= $this->Form->control('clinician_id', [
                                'id' => 'clinician-id',
                                'type' => 'select',
                                'options' => $clinicians,
                                'empty' => '-- Choose Clinician --',
                                'label' => false,
                                'required' => true,
                                'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                            ]) ?>
                        </div>

                        <div>
                            <label for="duration" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Duration</label>
                            <?= $this->Form->control('duration', [
                                'id' => 'duration',
                                'type' => 'select',
                                'options' => [
                                    30 => '30 Minutes',
                                    45 => '45 Minutes',
                                    60 => '1 Hour',
                                    90 => '1 Hours & 30 Minutes',
                                ],
                                'default' => 30,
                                'label' => false,
                                'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <h3 class="mb-4 text-lg font-semibold dark:text-white">2. Select Time</h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Step 2A: Pick Date -->
                        <div>
                            <label for="booking-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preferred Date</label>
                            <?= $this->Form->control('booking_date', [
                                'type' => 'date',
                                'id' => 'booking-date',
                                'label' => false,
                                'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-4 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                                'min' => date('Y-m-d', strtotime('+1 day')),
                                'max' => date('Y-m-d', strtotime('+90 days')),
                            ]) ?>
                        </div>

                        <!-- Step 2B: Pick Slot -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Available Times</label>

                            <div id="empty-state" class="p-4 text-sm text-center text-gray-500 bg-gray-50 rounded-lg dark:bg-gray-800 dark:text-gray-400 border border-dashed border-gray-300 dark:border-gray-600">
                                Select a clinician and date first.
                            </div>

                            <div id="time-slots" class="hidden grid grid-cols-2 gap-3 sm:grid-cols-3">
                                <!-- JS injects buttons here -->
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="xl:col-span-1">
                <?php if ($identity->role === 'admin') : ?>
                    <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                        <h3 class="mb-4 text-lg font-semibold dark:text-white">Admin Overrides</h3>
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
                                'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white',
                            ]) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <h3 class="mb-4 text-lg font-semibold dark:text-white">Additional Info</h3>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Write a note</label>
                        <?= $this->Form->textarea('notes', [
                            'rows' => 4,
                            'placeholder' => 'Any additional information or requests...',
                            'class' => 'block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-400'
                        ]) ?>
                    </div>
                </div>

                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                    <?= $this->element('button/blue_button', ['label' => 'Confirm Booking', 'type' => 'submit']) ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>

<?php $this->append('script'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clinicianSelect = document.getElementById('clinician-id');
            const dateInput = document.getElementById('booking-date');
            const durationSelect = document.getElementById('duration');
            const slotsContainer = document.getElementById('time-slots');
            const emptyState = document.getElementById('empty-state');
            const hiddenDateInput = document.getElementById('scheduled_date_hidden');
            const form = document.getElementById('booking-form');

            let blockedSlots = [];

            // 1. Fetch data from server
            function fetchAvailability(clinicianId) {
                if (!clinicianId) {
                    blockedSlots = [];
                    generateSlots();
                    return;
                }

                fetch(`/bookings/get-booked-slots/${clinicianId}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                    .then(res => res.json())
                    .then(data => {
                        blockedSlots = data.blocked || [];
                        generateSlots();
                    })
                    .catch(error => console.error('Error fetching availability:', error));
            }

            // 2. Check if a slot overlaps with known blocked data
            function checkOverlap(slotStart, slotEnd) {
                for (let i = 0; i < blockedSlots.length; i++) {
                    let blockStart = new Date(blockedSlots[i].from.replace(/-/g, '/')).getTime();
                    let blockEnd = new Date(blockedSlots[i].to.replace(/-/g, '/')).getTime();

                    if (slotStart < blockEnd && slotEnd > blockStart) {
                        return true;
                    }
                }
                return false;
            }

            // 3. Generate the UI buttons
            function generateSlots() {
                hiddenDateInput.value = '';

                const dateVal = dateInput.value;
                const clinicianId = clinicianSelect.value;

                if (!dateVal || !clinicianId) {
                    emptyState.classList.remove('hidden');
                    slotsContainer.classList.add('hidden');
                    return;
                }

                emptyState.classList.add('hidden');
                slotsContainer.classList.remove('hidden');
                slotsContainer.innerHTML = '';

                const durationMins = parseInt(durationSelect.value);
                const [year, month, day] = dateVal.split('-');

                // Setup Clinic Hours (9 AM to 5 PM)
                let currentTime = new Date(year, month - 1, day, 9, 0, 0);
                const endTime = new Date(year, month - 1, day, 17, 0, 0);

                let hasAvailableSlots = false;

                while (currentTime.getTime() + (durationMins * 60000) <= endTime.getTime()) {
                    let slotStart = currentTime.getTime();
                    let slotEnd = slotStart + (durationMins * 60000);

                    // Format Time (e.g., 9:30 AM)
                    let timeString = currentTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                    // Format SQL Datetime (YYYY-MM-DD HH:MM:00)
                    let hrs = String(currentTime.getHours()).padStart(2, '0');
                    let mins = String(currentTime.getMinutes()).padStart(2, '0');
                    let sqlValue = `${year}-${month}-${day} ${hrs}:${mins}:00`;

                    const isBlocked = checkOverlap(slotStart, slotEnd);
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.innerText = timeString;

                    if (isBlocked) {
                        // Disabled styling
                        btn.className = 'py-2 px-3 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 rounded-lg cursor-not-allowed dark:bg-gray-700 dark:text-gray-500 dark:border-gray-600 line-through';
                        btn.disabled = true;
                    } else {
                        hasAvailableSlots = true;
                        // Active styling
                        btn.className = 'time-slot-btn py-2 px-3 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-primary-50 hover:text-primary-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 transition-colors';
                        btn.dataset.val = sqlValue;

                        btn.addEventListener('click', function() {
                            // Reset all buttons
                            document.querySelectorAll('.time-slot-btn').forEach(b => {
                                b.classList.remove('ring-2', 'ring-primary-600', 'bg-primary-50', 'text-primary-700', 'dark:bg-primary-900', 'dark:text-white', 'border-primary-600');
                            });
                            // Highlight this button
                            this.classList.add('ring-2', 'ring-primary-600', 'bg-primary-50', 'text-primary-700', 'dark:bg-primary-900', 'dark:text-white', 'border-primary-600');

                            // Assign value to hidden input
                            hiddenDateInput.value = this.dataset.val;
                        });
                    }

                    slotsContainer.appendChild(btn);

                    // Advance loop by duration
                    currentTime.setMinutes(currentTime.getMinutes() + durationMins);
                }

                if (!hasAvailableSlots) {
                    slotsContainer.innerHTML = '<div class="col-span-full p-4 text-sm text-center text-red-600 bg-red-50 rounded-lg dark:bg-red-900/30 dark:text-red-400 border border-red-100 dark:border-red-800">Fully booked for this date.</div>';
                }
            }

            // 4. Attach Listeners
            dateInput.addEventListener('change', generateSlots);
            durationSelect.addEventListener('change', generateSlots);

            clinicianSelect.addEventListener('change', function(e) {
                fetchAvailability(e.target.value);
            });

            // 5. Form Validation
            form.addEventListener('submit', function(e) {
                if (!hiddenDateInput.value) {
                    e.preventDefault();
                    alert('Please select an available time slot before confirming your booking.');
                }
            });

            // Init if modifying existing selection
            if (clinicianSelect.value) {
                fetchAvailability(clinicianSelect.value);
            }
        });
    </script>
<?php $this->end(); ?>
