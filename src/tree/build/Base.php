<?php
namespace zongphp\tree\build;

class Base {

   protected $primary = 'id';
   protected $parentId = 'pid';
   protected $child = 'child';

   public function makeTree(&$data, $index = 0)
   {
       $childs = $this->findChild($data, $index);
       if (empty($childs)) {
           return $childs;
       }
       foreach ($childs as $k => &$v) {
           if (empty($data)) break;
           $child = $this->makeTree($data, $v[$this->primary]);
           if (!empty($child)) {
               $v[$this->child] = $child;
           }
       }
       unset($v);
       return $childs;
   }

   public function findChild(&$data, $index)
   {
       $childs = [];
       foreach ($data as $k => $v) {
           if ($v[$this->parentId] == $index) {
               $childs[] = $v;
               unset($v);
           }
       }
       return $childs;
   }

   public function getTreeNoFindChild($data)
   {
       $map = [];
       $tree = [];
       foreach ($data as &$it) {
           $map[$it[$this->primary]] = &$it;
       }
       foreach ($data as $key => &$it) {
           $parent = &$map[$it[$this->parentId]];
           if ($parent) {
               $parent['child'][] = &$it;
           } else {
               $tree[] = &$it;
               //$tree[]['child'] = null;
           }
       }
       return $tree;
   }

   public function getParents($data, $catId)
   {
       $tree = array();
       foreach ($data as $item) {
           if ($item[$this->primary] == $catId) {
               if ($item[$this->parentId] > 0)
                   $tree = array_merge($tree, $this->getParents($data, $item[$this->parentId]));
               $tree[] = $item;
               break;
           }
       }
       return $tree;
   }
}
