<?php
    class Pagination
    {
        public $limit;

        public function __construct($limit){
            $this->limit = $limit;
        }

        public function generate($page, $row)
        {
            $paginate = null;
            $limit    = $this->limit;
            $max      = ceil($row / $limit) == 0 ? 1 : ceil($row / $limit);

            $this->validatePage($page, $max);
            
            $index    = $this->getIndex($page, $max);
            $before   = $page-1;
            $after    = $page+1;
            
            $i        = $before;
            $item     = '<';
            $active   = '';
            $link     = "href = '/Board/index/{$i}'";
            $html     = $this->getHtml($item, $active, $link);

            $paginate .= $page != 1 ? $html : '';

            for ($i = $index['start']; $i <= $index['end']; $i++) {
                $active     = $page == $i ? 'active' : '';
                $link       = $page == $i ? '' : "href = '/Board/index/{$i}'";
                $html       = $this->getHtml($i, $active, $link);
                $paginate   .= $html;
            }

            $i         = $after;
            $item      = '>';
            $active    = '';
            $link      = "href = '/Board/index/{$i}'";
            $html      = $this->getHtml($item, $active, $link);
            $paginate  .= $page != $max ? $html : '';
            
            if ($max < 2){
                return null;
            } else {
                return $paginate;
            }
        }

        private function getHtml($item, $active, $link){
            ob_start();
            require(ROOT . 'views/pagination.php');
            return ob_get_clean();
        }

        private function getIndex($page, $max){
            $start    = 1;
            $end      = $max;

            if ($page == 2) {
                $end = $page + 3;
            } elseif ($page == 1) {
                $end = $page + 4;
            } elseif ($page == $max - 1) {
                $start = $page - 3;
            } elseif ($page == $max) {
                $start = $page - 4;
            } else {
                $start = $page - 2;
                $end = $page + 2;
            }

            if ($max < 5) {
                $start = 1;
                $end   = $max;
            }

            return array('start' => $start, 'end' => $end);
        }

        public function validatePage($index, $maxPage)
        {
            if ($index < 1 || !is_numeric($index)) {
                $return = 1;
            } elseif ($index > $maxPage) {
                $return = $maxPage;
            } 
            
            if (isset($return)) {   
                header("Location: /Board/index/{$return}");
            }
        }
    }
?>