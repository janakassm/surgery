<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set extends Guest_Controller {
	
	public $topic;
	
	private function ValidateTopic($id)
	{
		$this->topic = new Topic();
		$this->topic->topic_id = $id;
		if( $this->topic->IsTopic() )
		{
			return true;
		}
		else
		{
			return false;
		}
	} 
		
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
		
		$data = $this->input->post();
		
		$topicId = $this->input->post('topic_id');
		
		if( $this->ValidateTopic($topicId) )
		{
			$this->topic->topic_heading = $data['topic_heading'];
			$this->topic->topic_content = $data['topic_content'];
			
			if ( $this->topic->Save() )
			{
				jsonEcho(array('success'=>true, 'topicId' => $this->topic->topic_id));
			}
			else
				jsonEcho(array('success'=>false));
		}
		
	}
	
	public function deleteTopic()
	{
		$this->load->library('Topic');
		
		$data = $_POST;
		
		$topicId = $this->input->post('topic_id');
		
		if( $this->ValidateTopic($topicId) )
		{
			if ( $this->topic->Delete() )
			{
				jsonEcho(array('success'=>true, 'topicId' => $this->topic->topic_id));
			}
			else
				jsonEcho(array('success'=>false));
		}
	}
	
	public function addTopicVideo()
	{
		$this->load->library('Topic');
		
		$url = $this->input->post('url');
		$topicId = $this->input->post('topic_id');
		
		if( $this->ValidateTopic($topicId) )
		{
			if( $newId = $this->topic->InsertVideo($url))
			{
				jsonEcho(array('success'=>true, 'url'=> $url,'video_id' => $newId));
			}
			else
				jsonEcho(array('success'=>false));
		}
		
	}
	
	public function deleteTopicVideo()
	{
		$this->load->library('Topic');
		
		$videoId = $this->input->post('video_id');
		$topicId = $this->input->post('topic_id');
		
		
		if( $this->ValidateTopic($topicId) )
		{
			
			if ( $this->topic->DeleteVideo($videoId) )
			{
				jsonEcho( array('success'=>true, 'video_id' => $videoId) );
			}
			else
				jsonEcho(array('success'=>false));
		}
		else
		{
			jsonEcho(array('success'=>false));
		}
		
	}
}
