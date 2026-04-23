<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactMessages Model
 *
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 *
 * @method \App\Model\Entity\ContactMessage newEmptyEntity()
 * @method \App\Model\Entity\ContactMessage newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactMessage> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContactMessage get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ContactMessage findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ContactMessage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ContactMessage> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContactMessage|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ContactMessage saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ContactMessage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactMessage>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactMessage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactMessage> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactMessage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactMessage>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ContactMessage>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ContactMessage> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ContactMessagesTable extends Table
{

    // Enum for Status and Category
    public const STATUS_OPTIONS = ['new', 'pending', 'replied', 'closed'];
    public const CATEGORY_OPTIONS = ['General Inquiry', 'Technical Support', 'Billing', 'Feedback'];

    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('contact_messages');
        $this->setDisplayField('first_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('patient_id')
            ->allowEmptyString('patient_id');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 50)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name')
            ->add('first_name', 'validChars', [
                'rule' => ['custom', "/^[a-zA-Z']+$/"],
                'message' => __('First name can only contain letters and apostrophes.'),
            ]);;

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 50)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name')
            ->add('last_name', 'validChars', [
                'rule' => ['custom', "/^[a-zA-Z']+$/"],
                'message' => __('Last name can only contain letters and apostrophes.'),
            ]);

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('category')
            ->maxLength('category', 100)
            ->notEmptyString('category', 'Please select a category.')
            ->add('category', 'validValue', [
                'rule' => ['inList', self::CATEGORY_OPTIONS],
                'message' => 'Please select a valid category from the list.',
            ]);

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->add('status', 'validValue', [
                'rule' => ['inList', self::STATUS_OPTIONS],
                'message' => 'Invalid status value.',
            ]);

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);

        return $rules;
    }
}
