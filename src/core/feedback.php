<?php
namespace app\src\core;
use app\src\models\Database;

class Feedback{
	private int $semester;
	private string $class;
	private string $faculty;
	private string $subject;
	
	public function __construct(int $semester,string $class,string $faculty,string $subject) {
		$this->semester = $semester;
		$this->class = $class;
		$this->faculty = $faculty;
	}
	public function saveFeedback(){
	}
}