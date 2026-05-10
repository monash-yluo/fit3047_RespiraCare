<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Resources Model
 *
 * @method \App\Model\Entity\Resource newEmptyEntity()
 * @method \App\Model\Entity\Resource newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Resource> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Resource get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Resource findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Resource patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Resource> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Resource|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Resource saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Resource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Resource>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Resource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Resource> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Resource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Resource>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Resource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Resource> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ResourcesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('resources');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->date('published_date')
            ->allowEmptyDate('published_date');
            

        $validator
            ->scalar('type')
            ->maxLength('type', 50)
            ->requirePresence('type', 'create')
            ->notEmptyString('type')
            ->inList('type', ['Article', 'Video', 'PDF Document', 'External Link', 'Guide'], 'Please select a valid type.');

        $validator
            ->scalar('url_link')
            ->maxLength('url_link', 255)
            ->allowEmptyString('url_link');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->requirePresence('status', 'create')
            ->notEmptyString('status')
            ->inList('status', ['Active', 'Draft', 'Archived'], 'Please select a valid status.');

        return $validator;
    }
}
