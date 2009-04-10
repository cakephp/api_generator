<?php
/* SVN FILE: $Id$ */
/**
 * Api Generator Controller
 *
 *
 *
 * PHP versions 4 and 5
 *
 * CakePHP :  Rapid Development Framework <http://www.cakephp.org/>
 * Copyright 2006-2008, Cake Software Foundation, Inc.
 *								1785 E. Sahara Avenue, Suite 490-204
 *								Las Vegas, Nevada 89104
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright       Copyright 2006-2008, Cake Software Foundation, Inc.
 * @link            http://www.cakefoundation.org/projects/info/cakephp CakePHP Project
 * @package         cake
 * @subpackage      cake.
 * @version
 * @modifiedby
 * @lastmodified
 * @license         http://www.opensource.org/licenses/mit-license.php The MIT License
 */
class ApiGeneratorController extends ApiGeneratorAppController {
/**
 * Name property
 *
 * @var string
 */
	public $name = 'ApiGenerator';
/**
 * Uses array
 *
 * @var array
 */
	public $uses = array('ApiGenerator.ApiFile', 'ApiGenerator.ApiClass');
/**
 * Components array
 *
 * @var array
 **/
	public $components = array('RequestHandler', 'Security');
/**
 * Helpers
 *
 * @var array
 **/
	public $helpers = array('ApiGenerator.ApiDoc', 'ApiGenerator.ApiUtils', 'Html', 'Javascript', 'Text');

/**
 * beforeFilter callback
 *
 * @return void
 **/
	public function beforeFilter() {
		parent::beforeFilter();
		
		$this->ApiFile->ApiConfig->read();
		
		if (isset($this->ApiFile->ApiConfig->data['users'])) {
			$this->Security->loginUsers = $this->ApiFile->ApiConfig->data['users'];
		}
		$this->Security->loginOptions = array('type' => 'basic');
		$this->Security->requireLogin('admin_class_index', 'admin_docs_coverage');
	}
/**
 * Extract all the useful config info out of the ApiConfig.
 *
 * @return void
 **/
	public function beforeRender() {
		$this->set('basePath', $this->path);
		$this->set($this->ApiFile->getExclusions());
	}

/**
 * Browse application files and find things you would like to generate API docs for.
 *
 * @return void
 **/
	public function index() {
		$this->classes();
		if (!empty($this->viewVars['classIndex'])) {
			$this->render('classes');
			return;
		}
	}

/**
 * Browse application files and find things you would like to generate API docs for.
 *
 * @return void
 **/
	public function source() {
		if (count($this->passedArgs) == 1 && $this->passedArgs[0] == 'index') {
			array_shift($this->passedArgs);
		}
		$currentPath = implode('/', $this->passedArgs);
		$previousPath = implode('/', array_slice($this->passedArgs, 0, count($this->passedArgs) -1));
		list($dirs, $files) = $this->ApiFile->read($this->path . $currentPath);
		$this->set(compact('dirs', 'files', 'currentPath', 'previousPath'));
	}

/**
 * all_files
 *
 * Gets a recursive list of all files that match documentor criteria.
 *
 * @access public
 * @return void
 */
	public function files() {
		$files = $this->ApiFile->fileList($this->path);
		$this->set('files', $files);
	}

/**
 * Browse the classes in the application / API files.
 *
 * @return void
 **/
	public function classes() {
		$classIndex = $this->ApiClass->getClassIndex();
		$this->set('classIndex', $classIndex);
	}

/**
 * View the API docs for all interesting parts in a file.
 *
 * @return void
 **/
	public function view_file() {
		$currentPath = implode('/', $this->passedArgs);
		$fullPath = $this->path . $currentPath;
		$previousPath = implode('/', array_slice($this->passedArgs, 0, count($this->passedArgs) -1));
		$upOneFolder = implode('/', array_slice($this->passedArgs, 0, count($this->passedArgs) -2));

		if (!file_exists($fullPath)) {
			$this->_notFound(__('No file exists with that name', true));
		}
		try {
			$docs = $this->ApiFile->loadFile($fullPath, array('useIndex' => true));
		} catch(Exception $e) {
			$this->_notFound($e->getMessage());
		}
		$classIndex = $this->ApiClass->getClassIndex(true);
		list($dirs, $files) = $this->ApiFile->read($this->path . $previousPath);
		if (!empty($docs)) {
			$this->set('showSidebar', true);
			$this->set('sidebarElement', 'sidebar/file_sidebar');
			$this->set(compact('currentPath', 'previousPath', 'upOneFolder', 'docs', 'dirs', 'files', 'classIndex'));
		} else {
			$this->set('previousPath', $previousPath);
			$this->render('no_class');
		}
	}

/**
 * View API docs for a single class used with browse_classes
 *
 * @return void
 **/
	public function view_class($classSlug = null) {
		if (!$classSlug) {
			$this->Session->setFlash(__('No class name was given', true));
			$this->redirect($this->referer());
		}
		$classInfo = $this->ApiClass->findBySlug($classSlug);
		if (empty($classInfo['ApiClass']['file_name'])) {
			$this->_notFound(__('No class exists in the index with that name', true));
		}
		try {
			$docs = $this->ApiFile->loadFile($classInfo['ApiClass']['file_name'], array('useIndex' => true));
			$doc = $docs['class'][$classInfo['ApiClass']['name']];
		} catch(Exception $e) {
			$this->_notFound($e->getMessage());
		}

		$classIndex = $this->ApiClass->getClassIndex();
		if (!empty($docs)) {
			$this->set('showSidebar', true);
			$this->set('sidebarElement', 'sidebar/class_sidebar');
			$this->set(compact('doc', 'classIndex'));
		} else {
			$this->_notFound(__("Oops, seems we couldn't get the documentation for that class.", true));
		}
	}

/**
 * View the Source for a file.
 *
 * @return void
 **/
	public function view_source($classSlug = null) {
		$classInfo = $this->ApiClass->findBySlug($classSlug);

		if (empty($classInfo['ApiClass']['file_name'])) {
			$this->_notFound(__('No class exists in the index with that name', true));
		}
		$fileContents = file_get_contents($classInfo['ApiClass']['file_name']);
		$this->set('contents', $fileContents);
		$this->set('filename', $classInfo['ApiClass']['file_name']);
	}

/**
 * Search through the class index.
 *
 * @return void
 **/
	public function search($term = null) {
		$conditions = array();
		if (!empty($this->params['url']['query'])) {
			$term = $this->params['url']['query'];
			return $this->redirect(array($term));
		}
		$term = trim($term);
		$terms = explode(' ', $term);
		foreach ($terms as $i => $j) {
			if (trim($j) === '') {
				unset ($terms[$i]);
			}
		}
		$docs = $this->ApiClass->search($terms);
		$classIndex = $this->ApiClass->getClassIndex();
		$this->set(compact('classIndex', 'terms', 'docs'));
	}

///////////// Admin methods
/**
 * Admin Class index. View a list of classes in the index and get admin actions for
 * them.
 *
 * @return void
 **/
	public function admin_class_index() {
		$this->set('apiClasses', $this->paginate('ApiClass'));
	}
/**
 * Get docs coverage for a class
 *
 * @return void
 **/
	public function admin_docs_coverage($className = null) {
		$apiClass = $this->ApiClass->findBySlug($className);
		if (empty($apiClass)) {
			$this->_notFound(__('No class exists with that name', true));
		}
		try {
			$analysis = $this->ApiClass->analyzeCoverage($apiClass);
		} catch(Exception $e) {
			$this->_notFound($e->getMessage());
		}
		$backwards = $this->referer();
		$this->helpers[] = 'Number';
		$this->set(compact('apiClass', 'analysis', 'backwards'));
	}
/**
 * Calculates the coverage for a class, Used via XHR to get coverage as user
 * looks at index page.
 *
 * @return void
 **/
	public function calculate_coverage($id = null) {
		$apiClass = $this->ApiClass->findById($id);
		if (empty($apiClass)) {
			$this->_notFound(__('No class exists with that name', true));
		}
		try {
			$analysis = $this->ApiClass->analyzeCoverage($apiClass);
		} catch(Exception $e) {
			$this->_notFound($e->getMessage());
		}
		$this->set(compact('analysis'));
	}
}