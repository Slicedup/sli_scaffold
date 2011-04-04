<?php
/**
 * Slicedup: a fancy tag line here
 *
 * @copyright	Copyright 2011, Paul Webster / Slicedup (http://slicedup.org)
 * @license 	http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace slicedup_scaffold\tests\cases\extensions\data;

use slicedup_scaffold\extensions\data;

use slicedup_scaffold\extensions\data\Model;
use lithium\data\Connections;

class ModelTest extends \lithium\test\Unit {

	protected $_post = 'slicedup_scaffold\tests\mocks\data\MockPost';

	public function setUp() {
		$this->_configs = Connections::config();
		Connections::config($this->_configs + array('mock-source' => array(
			'type' => 'lithium\tests\mocks\data\MockSource'
		)));
		$post = $this->_post;
		$post::config();
	}

	public function tearDown() {
		Connections::config(array('mock-source' => false));
		Connections::config($this->_configs);
		$post = $this->_post;
		$post::flush();
	}

	public function testUnsetScaffoldFields() {
		$post = $this->_post;
		$schema = $post::schema();
		$fields = Model::getFields($post);
		$expected = array_keys($schema);
		$result = array_keys($fields);
		$this->assertEqual($expected, $result);

		$scaffoldFields = Model::getScaffoldFields($post);
		$this->assertEqual($fields, $scaffoldFields);
		$scaffoldFields = Model::getFields($post, 'scaffold');
		$this->assertEqual($fields, $scaffoldFields);

		$summaryFields = Model::getSummaryFields($post);
		$this->assertEqual($fields, $summaryFields);
		$summaryFields = Model::getFields($post, 'summary');
		$this->assertEqual($fields, $summaryFields);

		$detailFields = Model::getDetailFields($post);
		$this->assertEqual($fields, $detailFields);
		$detailFields = Model::getFields($post, 'detail');
		$this->assertEqual($fields, $detailFields);

		$anyOtherFields = Model::getAnyOtherFields($post);
		$this->assertEqual($fields, $anyOtherFields);
		$anyOtherFields = Model::getFields($post, 'AnyOther');
		$this->assertEqual($fields, $anyOtherFields);
	}

	public function testScaffoldFields() {
		$post = $this->_post;
		$setScaffoldFields = array('id', 'title', 'body', 'status');
		$instance = $post::invokeMethod('_object');
		$instance->scaffoldFields = $setScaffoldFields;

		$fields = Model::getFields($post);
		$expected = $setScaffoldFields;
		$result = array_keys($fields);
		$this->assertEqual($expected, $result);

		$summaryFields = Model::getSummaryFields($post);
		$this->assertEqual($fields, $summaryFields);
		$summaryFields = Model::getFields($post, 'summary');
		$this->assertEqual($fields, $summaryFields);

		$setSummaryFields = array('id', 'title', 'status', 'created');
		$instance->summaryFields = $setSummaryFields;
		$summaryFields = Model::getSummaryFields($post);
		$this->assertEqual($setSummaryFields, array_keys($summaryFields));
		$summaryFields = Model::getFields($post, 'summary');
		$this->assertEqual($setSummaryFields, array_keys($summaryFields));

		$detailFields = Model::getDetailFields($post);
		$this->assertEqual($fields, $detailFields);
		$detailFields = Model::getFields($post, 'detail');
		$this->assertEqual($fields, $detailFields);

		$setDetailFields = array('id', 'title', 'status', 'created');
		$instance->detailFields = $setDetailFields;
		$detailFields = Model::getDetailFields($post);
		$this->assertEqual($setDetailFields, array_keys($detailFields));
		$detailFields = Model::getFields($post, 'detail');
		$this->assertEqual($setDetailFields, array_keys($detailFields));

		$anyOtherFields = Model::getAnyOtherFields($post);
		$this->assertEqual($fields, $anyOtherFields);
		$anyOtherFields = Model::getFields($post, 'AnyOther');
		$this->assertEqual($fields, $anyOtherFields);

		$setAnyOtherFields = array('id', 'created', 'modified');
		$instance->anyOtherFields = $setAnyOtherFields;
		$anyOtherFields = Model::getAnyOtherFields($post);
		$this->assertEqual($setAnyOtherFields, array_keys($anyOtherFields));
		$anyOtherFields = Model::getFields($post, 'anyOther');
		$this->assertEqual($setAnyOtherFields, array_keys($anyOtherFields));
		$anyOtherFields = Model::getFields($post, 'AnyOther');
		$this->assertEqual($setAnyOtherFields, array_keys($anyOtherFields));
		$anyOtherFields = Model::getFields($post, 'any_other');
		$this->assertEqual($setAnyOtherFields, array_keys($anyOtherFields));
	}

	public function testUnsetScaffoldFormFields() {
		$post = $this->_post;
		$schema = $post::schema();
		$fields = Model::getFormFields($post);
		$expected = array(Model::mapFormFields($schema));
		$this->assertEqual($expected, $fields);

		$scaffoldFields = Model::getScaffoldFormFields($post);
		$this->assertEqual($fields, $scaffoldFields);
		$scaffoldFields = Model::getFormFields($post, 'scaffold');
		$this->assertEqual($fields, $scaffoldFields);
		$scaffoldFields = Model::getFormFields($post, 'scaffoldForm');
		$this->assertEqual($fields, $scaffoldFields);

		$createFields = Model::getCreateFormFields($post);
		$this->assertEqual($fields, $createFields);
		$createFields = Model::getFormFields($post, 'create');
		$this->assertEqual($fields, $createFields);

		$updateFields = Model::getUpdateFormFields($post);
		$this->assertEqual($fields, $updateFields);
		$updateFields = Model::getFormFields($post, 'update');
		$this->assertEqual($fields, $updateFields);
	}

}

?>