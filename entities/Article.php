<?php
class Article {
    private $id;
    private $title;
    private $content;
    private $imageUrl;

    public function __construct($id, $title, $content, $imageUrl = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->imageUrl = $imageUrl;
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getContent() { return $this->content; }
    public function getImageUrl() { return $this->imageUrl; }

    public function setTitle($title) { $this->title = $title; }
    public function setContent($content) { $this->content = $content; }
    public function setImageUrl($imageUrl) { $this->imageUrl = $imageUrl; }
}
