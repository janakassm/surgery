<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set extends Guest_Controller {
		
	public function newTopic()
	{
		$this->load->library('Topic');
		
		$articleId = $_POST['articleId'];
		
		$topic = new Topic();
		if ( $topic->PreRegister($articleId) )
		{
			jsonEcho(array('success'=>true, 'topicId' => $topic->topic_id));
		}
		else
			jsonEcho(array('success'=>false));
		
	}
	
	public function saveTopic()
	{
		$this->load->library('Topic');
		
		$data = $_POST;
		
		$topic = new Topic();
		$topic->topic_id = $data['topic_id'];
		
		if( $topic->IsTopic() )
		{
			$topic->topic_heading = $data['topic_heading'];
			$topic->topic_content = $data['topic_content'];
			
			if ( $topic->Save() )
			{
				jsonEcho(array('success'=>true, 'topicId' => $topic->topic_id));
			}
			else
				jsonEcho(array('success'=>false));
		}
		
	}
	
	public function deleteTopic()
	{
		$this->load->library('Topic');
		
		$data = $_POST;
		
		$topic = new Topic();
		$topic->topic_id = $data['topic_id'];
		
		if( $topic->IsTopic() )
		{
			if ( $topic->Delete() )
			{
				jsonEcho(array('success'=>true, 'topicId' => $topic->topic_id));
			}
			else
				jsonEcho(array('success'=>false));
		}
	}
	
}
