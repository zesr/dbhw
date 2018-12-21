<?php

//被getTable调用，用于创建表格页面
    class Page {  
          private $total;      //总记录  
          private $pagesize;    //每页显示多少条  
          private $limit;          //limit  
          private $page;           //当前页码  
          private $pagenum;      //总页码  
          private $url;           //地址  
          private $bothnum;      //两边保持数字分页的量  
    
      //构造方法初始化  
      public function __construct($_total, $_pagesize) {  
         $this->total = $_total ? $_total : 1;  
         $this->pagesize = $_pagesize;  
         $this->pagenum = ceil($this->total / $this->pagesize);  
         $this->page = $this->setPage();  
         $this->limit = " LIMIT ".($this->page-1)*$this->pagesize.",$this->pagesize";  
         $this->url = $this->setUrl();  
         $this->bothnum = 2;  
      }  
    
      //拦截器  
      public function __get($_key) {  
         return $this->$_key;  
      }  
    
      //获取当前页码  
      private function setPage() {  
         if (!empty($_GET['page'])) {  
                if ($_GET['page'] > 0) {  
                   if ($_GET['page'] > $this->pagenum) {  
                          return $this->pagenum;  
                   } else {  
                          return $_GET['page'];  
                   }  
                } else {  
                   return 1;  
                }  
         } else {  
                return 1;  
         }  
      }   
    
      //获取地址  
      private function setUrl() {  
        $_url = $_SERVER["REQUEST_URI"];  
        $_par = parse_url($_url);  
        if (isset($_par['query'])) {  
            parse_str($_par['query'],$_query);  
            unset($_query['page']);  
            $_url = $_par['path']."?".http_build_query($_query);  
        }else{
            $_url = $_par['path']."?";
        }
        return $_url;
      }     //数字目录  
      private function pageList() {  
        $_pagelist = "";
         for ($i=$this->bothnum;$i>=1;$i--) {  
            $_page = $this->page-$i;  
            if ($_page < 1) continue;  
                $_pagelist .= ' <li class="waves-effect"><a class="page_lab" href="'.$this->url.'&page='.$_page.'">'.$_page.'</a></li> ';  
         }  
         $_pagelist .= ' <li class="active pink darken-1" id="now_page"><a class="me" href="#!">'.$this->page.'</a></li> ';
         for ($i=1;$i<=$this->bothnum;$i++) {  
            $_page = $this->page+$i;  
                if ($_page > $this->pagenum) break;  
                $_pagelist .= ' <li class="waves-effect"><a class="page_lab" href="'.$this->url.'&page='.$_page.'">'.$_page.'</a></li> ';  
         }  
         return $_pagelist;  
      }  
    
      //首页  
      private function first() {  
         if ($this->page > $this->bothnum+1) {  
                return ' <li class="waves-effect"><a class="page_lab" href="'.$this->url.'">1</a></li> ...';  
         }  
      }  
    
      //上一页  
      private function prev() {  
         if ($this->page == 1) {  
                return '<li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>';  
         }  
         return ' <li class="waves-effect"><a class="page_lab" href="'.$this->url.'&page='.($this->page-1).'"><i class="material-icons">chevron_left</i></a></li> ';  
      }  
    
      //下一页  
      private function next() {  
         if ($this->page == $this->pagenum) {  
                return '<li class="disabled"><a href="#!"><i class="material-icons">chevron_right</i></a></li>';  
         }  
         return ' <li class="waves-effect"><a class="page_lab" href="'.$this->url.'&page='.($this->page+1).'"><i class="material-icons">chevron_right</i></a></li> ';  
      }  
    
      //尾页  
      private function last() {  
         if ($this->pagenum - $this->page > $this->bothnum) {  
                return ' ...<li class="waves-effect"><a class="page_lab" href="'.$this->url.'&page='.$this->pagenum.'">'.$this->pagenum.'</a></li> ';  
         }  
      }  
    
      //分页信息  
      public function showpage() {
         $_page = "";
         $_page .= $this->prev();
         $_page .= $this->first();  
         $_page .= $this->pageList();  
         $_page .= $this->last();    
         $_page .= $this->next();  
         return $_page;  
      }  
 }  
?>  