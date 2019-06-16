<?php 
class Pagination  
{
    public $current_page;
    public $per_page;
    public $total_count;
    public function __construct($page=1,$per_page=20,$total=0)
    {
        $this->current_page=(int)$page;
        $this->per_page=(int)$per_page;
        $this->total_count=(int)$total;
    }
    public function total_pages()
    {
        return ceil($this->total_count/$this->per_page);
    }
    public function offset()
    {
        return $this->per_page*($this->current_page-1);
    }
    public function previous_page()
    {
        return $this->current_page - 1;
    }
    public function next_page()
    {
        return $this->current_page + 1;
    }
    public function has_previous()
    {
        if ($this->previous_page()>=1) {
            return true;
        }else{
            return false;
        }
    }
    public function has_next()
    {
        if ($this->next_page()<=$this->total_pages()) {
            return true;
        }else{
            return false;
        }
    }
}
