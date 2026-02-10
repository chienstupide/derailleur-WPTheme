<?php
namespace App;



class DerailleurMetaPost{
    
    CONST PREFIX="derailleur_";
    
    public function __construct(
        private string $hook,
        private string $id,
        private string $title, 
        private string $post_type,
        private $fields=[]
        )
    {
        add_action($hook, [&$this,'render']);
        add_action('save_post', [&$this,'save']);
    
    }
    private function get_current_post_id() {
        if (isset($_GET['post'])) {
            return (int) $_GET['post'];
        }

        if (isset($_POST['post_ID'])) {
            return (int) $_POST['post_ID'];
        }

        return 0;
    }


    public function add($id, $label, $type='text', $option=[]): self
    {
        $this->fields[] = [
            'id' => $id, 
            'label' => $label, 
            'type' => $type,
            'option' => $option
        ];
    

        return $this;
    }

    public function render(){

                add_meta_box(
                self::PREFIX.$this->id,           // Unique ID
                $this->title,      // Box title
                [&$this,'html'],  // Content callback, must be of type callable
                $this->post_type ,
                'side'                          // Post type
            );
    }

    public function html(): void
    {
        foreach($this->fields as $field){

            $value = get_post_meta(get_the_ID(), '_'.self::PREFIX.$field['id'].'_key', true);
            $name = self::PREFIX.$field['id'].'_field';
            $label = $field['label'];
            
            $this->add_nonce($field['id']);

            require __DIR__. '/' .$field['type']. '.php';

        }
    
   
    }

    public function add_nonce($id): void
    {
        wp_nonce_field( self::PREFIX.$id.'_nonce', self::PREFIX.$id.'_nonce' );
    }

    public function verif_nonce($id): bool
    {
        return wp_verify_nonce( $_POST[self::PREFIX.$id.'_nonce'], self::PREFIX.$id.'_nonce' );

    }

    public function save(): void
    {
        foreach($this->fields as $field){
            $name = self::PREFIX.$field['id'].'_field';
            if (
                array_key_exists($name, $_POST)
                && 
                $this->verif_nonce($field['id'])
            )
                {
                
                update_post_meta(
                    $this->get_current_post_id(),
                    '_'.self::PREFIX.$field['id'].'_key',
                    $_POST[$name]
                );
            }
    
    }
    }

}