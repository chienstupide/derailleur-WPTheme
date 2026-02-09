<?php
namespace App;

class DerailleurMeta{

CONST PREFIX="derailleur_";
    public function __construct(
        private string $hook,
        private array $fields)
        {
// $fields =['type' => 'text', 'name' => 'contact_phone'];
         add_action($hook, [&$this,'create_fields']);

    }

    public function my_custom_section_callback(){
	// echo 'Champs personnalisés pour les informations de contact';
}


    // function my_custom_field_callback(){
	// echo '<fieldset><legend class="screen-reader-text"><span>Information de contact</span></legend>
    //         <br>
    //         <label>Téléphone : <input name="derailleur_contact_phone" value="'. get_option('derailleur_contact_phone') .'" /></label>
    //         <br>
    //         <label>Adresse : <input name="derailleur_contact_address" value="'. get_option('derailleur_contact_address') .'" /></label>
    //         <br>
    //         <label>Email : <input name="derailleur_contact_email" value="'. get_option('derailleur_contact_email') .'" /></label>
    //         </fieldset>';

    // }
    public function add_field($name){
	echo '<input name="'.self::PREFIX.$name.'" value="'. get_option(self::PREFIX.$name) .'" />';
    }




public function create_fields()
{
	add_settings_section(
		'derailleur_contact_section', //id of the section
		'',
		[&$this,'my_custom_section_callback'],
		'general',
		
	);
    foreach($this->fields as $field){

    $this->derailleur_contact_info_settings($field['name']);

     add_settings_field(
		self::PREFIX.$field['name'],
		$field['name'],
         function(...$args) use ($field){
                        $this->add_field($field['name']);
                    },
		'general',
	);
        }


	//add a sample field to this section.
	
}
    public function derailleur_contact_info_settings($name){
        register_setting( 'general', self::PREFIX.$name );
    }

}