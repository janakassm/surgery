<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Set extends Guest_Controller {
	
	public $topic;
	public $article;
	
	private function ValidateTopic($id)
	{
		$this->load->library('Topic');
		
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
	
	private function ValidateArticle($id)
	{
		$this->load->library('Article');
		
		$this->article = new Article();
		$this->article->article_id = $id;
		if( $this->article->IsArticle() )
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
		
		$articleId = $this->input->post('article_id');;
		
		$topic = new Topic();
		if ($this->ValidateArticle($articleId) && $topic->PreRegister($articleId) )
		{
			jsonEcho(array('success'=>true, 'topicId' => $topic->topic_id));
		}
		else
			jsonEcho(array('success'=>false));
		
	}
	
	public function saveTopic()
	{	
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
		
		
		$url = $this->input->post('url');
		$topicId = $this->input->post('topic_id');
		
		if( $this->ValidateTopic($topicId) )
		{
			if( $videoData = $this->topic->InsertVideo($url))
			{
				jsonEcho(array('success'=>true, 'url'=> $videoData->video_url,'video_id' => $videoData->video_id, 'video_title' => $videoData->video_title));
			}
			else
				jsonEcho(array('success'=>false));
		}
		
	}
	
	public function deleteTopicVideo()
	{
		
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
	
	public function addArticleCategory()
	{
		$this->load->library('Category');
		
		$catId = $this->input->post('cat_id');
		$articleId = $this->input->post('article_id');
		
		$category = new Category();
		$category->category_id = $catId;
		
		if( $this->ValidateArticle($articleId) && $category->IsCategory())
		{
			$categoryFound = false;
			foreach ($this->article->GetCategoryList() as $tmpCategory)
			{
				if($tmpCategory->category_id == $catId)
				{
					$categoryFound = true;
					break;
				}
			}
			
			
			if (!$categoryFound)
			{
				if( $this->article->InsertCategory($category->category_id) )
				{
					
					jsonEcho(array('success'=>true, 'category_id'=> $category->category_id,'category_title_sin' => $category->category_title_sin, 'category_title_eng' => $category->category_title_eng));
				}
				else
					jsonEcho(array('success'=>false));
				}
			else 
			{
				jsonEcho(array('success'=>false, 'error' => 'Category already exist'));
			}
		}
		
	}
	
	public function deleteArticleCategory()
	{
		$this->load->library('Category');
		
		$catId = $this->input->post('cat_id');
		$articleId = $this->input->post('article_id');
		
		
		
		if( $this->ValidateArticle($articleId) )
		{
			$categoryFound = false;
			
			
			foreach ($this->article->GetCategoryList() as  $category)
			{
				if($category->category_id == $catId)
				{
					$catId = $category->category_id;
					$categoryFound = true;
					break;
				}
			}
			
			if ($categoryFound && $this->article->DeleteCategory($catId) )
			{
				jsonEcho( array('success'=>true, 'category_id' => $catId) );
			}
			else
				jsonEcho(array('success'=>false, 'error' => 'Category Not found'));
		}
		else
		{
			jsonEcho(array('success'=>false, 'error' => 'Invalid article'));
		}
		
	}

	

}
