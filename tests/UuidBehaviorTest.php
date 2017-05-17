<?php

namespace UuidBehavior\tests;

use Propel\Generator\Util\QuickBuilder;

class UuidBehaviorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (!class_exists('TableWithUuidBehavior')) {
            $schema = <<<EOF
<database name="uuid_behavior" defaultIdMethod="native">
    <table name="table_with_uuid_behavior">
        <column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />

        <behavior name="uuid" />
    </table>
    <table name="table_with_uuid_behavior_with_custom_column">
        <column name="id" required="true" primaryKey="true" autoIncrement="true" type="INTEGER" />

        <behavior name="uuid">
            <parameter name="uuid_column" value="my_uuid" />
        </behavior>
    </table>
</database>
EOF;
            $builder = new QuickBuilder();
            $config  = $builder->getConfig();
            $builder->setConfig($config);
            $builder->setSchema($schema);

            $builder->build();
        }
    }

    public function testPreSaveThrowAnExceptionOnInvalidUuid()
    {
        $post = new \TableWithUuidBehavior();
        $post->setUuid("bad_uuid");

        try {
            $post->save();
            $this->fail('Expected exception not thrown') ;
        } catch (\Exception $e) {
            $this->assertTrue(true);
            $this->assertInstanceOf('InvalidArgumentException', $e);
        }
    }

    public function testPreSave()
    {
        $post = new \TableWithUuidBehavior();
        
        $post->save();
        $this->assertFalse(is_null($post->getUuid()));
    }
    
    public function testPreSaveCustom()
    {
        $post = new \TableWithUuidBehaviorWithCustomColumn();
        
        $post->save();
        $this->assertFalse(is_null($post->getMyUuid()));
    }

}