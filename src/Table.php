<?php
    /**
     * NonDB - A NoSQL Database
     * 
     * This Program licensed under MIT.
     * Use it under the Law and the License.
     * 
     * @author Tianle Xu<xtl@xtlsoft.top>
     * @package NonDB
     * @license MIT
     * @category database
     * @link https://github.com/xtlsoft/NonDB/
     * 
     */

    namespace NonDB;

    class Table implements \ArrayAccess, \Countable {

        use \NonDB\Components\ParentClass;
        use \NonDB\Components\Data;
        use \NonDB\Components\ArrayAccess;

        /**
         * Name of the table
         *
         * @var string
         * 
         */
        protected $name;

        /**
         * The data
         *
         * @var array
         * 
         */
        public $data;

        /**
         * Constructor
         *
         * @param mixed $name
         * 
         */
        public function __construct(string $name){

            $this->name = $name;
            $this->parentCallback = function(){
                $this->sync();
            };

        }

        /**
         * Sync the data
         *
         * @return self
         * 
         */
        public function sync(){

            $this->data = $this->parent->driver->getData($this->name);

            return $this;

        }

        /**
         * Save the data
         *
         * @return self
         * 
         */
        public function save(){

            $this->parent->driver->setData($this->name, $this->data);

            return $this;

        }

        /**
         * Get Auto-Increment Number
         * 
         * @return int
         * 
         */
        function autoincrement(){
            
            if(!isset($this->data['_NonDB_System_']['_AutoIncrement_'])){
                $this->data['_NonDB_System_']['_AutoIncrement_'] = 1;
            }

            $number = ($this->data['_NonDB_System_']['_AutoIncrement_'] ++);
            $this->save();

            return $number;

        }

    }
