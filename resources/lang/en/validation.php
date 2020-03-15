<?php



// VALIDACIÓN EN ESPAÑOL
return [

	/*
	|--------------------------------------------------------------------------
	| Validación del idioma
	|--------------------------------------------------------------------------
	|
        | Las siguientes líneas de idioma contienen los mensajes de error predeterminados utilizados por
        | La clase validadora Algunas de estas reglas tienen múltiples versiones tales
        | como las reglas de tamaño Siéntase libre de modificar cada uno de estos mensajes aquí
	|
	*/


	'accepted'              => 'el campo :attribute debe ser aceptado',
	'active_url'            => 'el campo :attribute no es una URL válida',
	'after'                 => 'el campo :attribute debe ser una fecha después de :date',
	'after_or_equal'        => 'el campo :attribute debe ser una fecha después o igual a :date',
	'alpha'                 => 'el campo :attribute sólo puede contener letras',
	'alpha_dash'            => 'el campo :attribute sólo puede contener letras, números y guiones',
	'alpha_num'             => 'el campo :attribute sólo puede contener letras y números',
	'array'                 => 'el campo :attribute debe ser un arreglo',
	'before'                => 'el campo :attribute debe ser una fecha antes de :date',
	'before_or_equal'       => 'el campo :attribute debe ser una fecha antes o igual a :date',
	'between'               => [
		'numeric' => 'el campo :attribute debe estar entre :min - :max',
		'file'    => 'el campo :attribute debe estar entre :min - :max kilobytes',
		'string'  => 'el campo :attribute debe estar entre :min - :max caracteres',
		'array'   => 'el campo :attribute debe tener entre :min y :max elementos',
	],
	'boolean'               => 'el campo :attribute debe ser verdadero o falso',
	'confirmed'             => 'el campo de confirmación de :attribute no coincide',
	'date'                  => 'el campo :attribute no es una fecha válida',
	'date_format' 	        => 'el campo :attribute no corresponde con el formato :format',
	'different'             => 'Los campos :attribute y :other deben ser diferentes',
	'digits'                => 'el campo :attribute debe ser de :digits dígitos',
	'digits_between'        => 'el campo :attribute debe tener entre :min y :max dígitos',
	'dimensions'            => 'el campo :attribute no tiene una dimensión válida',
	'distinct'              => 'el campo :attribute tiene un valor duplicado',
	'email'                 => 'el formato del :attribute es inválido',
	'exists'                => 'el campo :attribute seleccionado es inválido',
	'file'                  => 'el campo :attribute debe ser un archivo',
	'filled'                => 'el campo :attribute es requerido',
	'gt'                    => [
		'numeric' => 'el campo :attribute debe ser mayor que :value',
		'file'    => 'el campo :attribute debe ser mayor que :value kilobytes',
		'string'  => 'el campo :attribute debe ser mayor que :value caracteres',
		'array'   => 'el campo :attribute puede tener hasta :value elementos',
	],
	'gte'                   => [
		'numeric' => 'el campo :attribute debe ser mayor o igual que :value',
		'file'    => 'el campo :attribute debe ser mayor o igual que :value kilobytes',
		'string'  => 'el campo :attribute debe ser mayor o igual que :value caracteres',
		'array'   => 'el campo :attribute puede tener :value elementos o más',
	],
	'image'                 => 'el campo :attribute debe ser una imagen',
	'in'                    => 'el campo :attribute seleccionado es inválido',
	'in_array'              => 'el campo :attribute no existe en :other',
	'integer'               => 'el campo :attribute debe ser un entero',
	'ip'                    => 'el campo :attribute debe ser una dirección IP válida',
	'ipv4'                  => 'el campo :attribute debe ser una dirección IPv4 válida',
	'ipv6'                  => 'el campo :attribute debe ser una dirección IPv6 válida',
	'json'                  => 'el campo :attribute debe ser una cadena JSON válida',
	'lt'                   => [
		'numeric' => 'el campo :attribute debe ser menor que :max',
		'file'    => 'el campo :attribute debe ser menor que :max kilobytes',
		'string'  => 'el campo :attribute debe ser menor que :max caracteres',
		'array'   => 'el campo :attribute puede tener hasta :max elementos',
	],
	'lte'                   => [
		'numeric' => 'el campo :attribute debe ser menor o igual que :max',
		'file'    => 'el campo :attribute debe ser menor o igual que :max kilobytes',
		'string'  => 'el campo :attribute debe ser menor o igual que :max caracteres',
		'array'   => 'el campo :attribute no puede tener más que :max elementos',
	],
	'max'                   => [
		'numeric' => 'el campo :attribute debe ser menor que :max',
		'file'    => 'el campo :attribute debe ser menor que :max kilobytes',
		'string'  => 'el campo :attribute debe ser menor que :max caracteres',
		'array'   => 'el campo :attribute puede tener hasta :max elementos',
	],
	'mimes'                 => 'el campo :attribute debe ser un archivo de tipo: :values',
	'mimetypes'             => 'el campo :attribute debe ser un archivo de tipo: :values',
	'min'                   => [
		'numeric' => 'el campo :attribute debe tener al menos :min',
		'file'    => 'el campo :attribute debe tener al menos :min kilobytes',
		'string'  => 'el campo :attribute debe tener al menos :min caracteres',
		'array'   => 'el campo :attribute debe tener al menos :min elementos',
	],
	'not_in'                => 'el campo :attribute seleccionado es invalido',
	'not_regex'             => 'el formato del campo :attribute es inválido',
	'numeric'               => 'el campo :attribute debe ser un número',
	'present'               => 'el campo :attribute debe estar presente',
	'regex'                 => 'el formato del campo :attribute es inválido',
	'required'              => 'el campo :attribute es requerido',
	'required_if'           => 'el campo :attribute es requerido cuando el campo :other es :value',
	'required_unless'       => 'el campo :attribute es requerido a menos que :other esté presente en :values',
	'required_with'         => 'el campo :attribute es requerido cuando :values está presente',
	'required_with_all'     => 'el campo :attribute es requerido cuando :values está presente',
	'required_without'      => 'el campo :attribute es requerido cuando :values no está presente',
	'required_without_all'  => 'el campo :attribute es requerido cuando ningún :values está presente',
	'same'                  => 'el campo :attribute y :other debe coincidir',
	'size'                  => [
		'numeric' => 'el campo :attribute debe ser :size',
		'file'    => 'el campo :attribute debe tener :size kilobytes',
		'string'  => 'el campo :attribute debe tener :size caracteres',
		'array'   => 'el campo :attribute debe contener :size elementos',
	],
	'starts_with'           => 'el :attribute debe empezar con uno de los siguientes valores :values',
	'string'                => 'el campo :attribute debe ser una cadena',
	'timezone'              => 'el campo :attribute debe ser una zona válida',
	'unique'                => 'el campo :attribute ya ha sido tomado',
	'uploaded'              => 'el campo :attribute no ha podido ser cargado',	
	'url'                   => 'el formato de :attribute es inválido',
	'uuid'                  => 'el :attribute debe ser un UUID valido',
	
	/*
	|--------------------------------------------------------------------------
	| Validación del idioma personalizado
	|--------------------------------------------------------------------------
	|
	|	Aquí puede especificar mensajes de validación personalizados para atributos utilizando el
	| convención "attributerule" para nombrar las líneas Esto hace que sea rápido
	| especifique una línea de idioma personalizada específica para una regla de atributo dada
	|
	*/

	'custom' => [
		'attribute-name' => [
			'rule-name'  => 'custom-message',
		],
	],

	/*
	|--------------------------------------------------------------------------
	| Atributos de validación personalizados
	|--------------------------------------------------------------------------
	|
        | Las siguientes líneas de idioma se utilizan para intercambiar los marcadores de posición de atributo
        | con algo más fácil de leer, como la dirección de correo electrónico
        | de "email" Esto simplemente nos ayuda a hacer los mensajes un poco más limpios
	|
	*/

	'attributes' => [],
	
];


// VALIDACIÓN PREDETERMINADA

// return [

//     /*
//     |--------------------------------------------------------------------------
//     | Validation Language Lines
//     |--------------------------------------------------------------------------
//     |
//     | The following language lines contain the default error messages used by
//     | the validator class Some of these rules have multiple versions such
//     | as the size rules Feel free to tweak each of these messages here
//     |
//     */

//     'accepted'             => 'The :attribute must be accepted',
//     'active_url'           => 'The :attribute is not a valid URL',
//     'after'                => 'The :attribute must be a date after :date',
//     'after_or_equal'       => 'The :attribute must be a date after or equal to :date',
//     'alpha'                => 'The :attribute may only contain letters',
//     'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes',
//     'alpha_num'            => 'The :attribute may only contain letters and numbers',
//     'array'                => 'The :attribute must be an array',
//     'before'               => 'The :attribute must be a date before :date',
//     'before_or_equal'      => 'The :attribute must be a date before or equal to :date',
//     'between'              => [
//         'numeric' => 'The :attribute must be between :min and :max',
//         'file'    => 'The :attribute must be between :min and :max kilobytes',
//         'string'  => 'The :attribute must be between :min and :max characters',
//         'array'   => 'The :attribute must have between :min and :max items',
//     ],
//     'boolean'              => 'The :attribute field must be true or false',
//     'confirmed'            => 'The :attribute confirmation does not match',
//     'date'                 => 'The :attribute is not a valid date',
//     'date_format'          => 'The :attribute does not match the format :format',
//     'different'            => 'The :attribute and :other must be different',
//     'digits'               => 'The :attribute must be :digits digits',
//     'digits_between'       => 'The :attribute must be between :min and :max digits',
//     'dimensions'           => 'The :attribute has invalid image dimensions',
//     'distinct'             => 'The :attribute field has a duplicate value',
//     'email'                => 'The :attribute must be a valid email address',
//     'exists'               => 'The selected :attribute is invalid',
//     'file'                 => 'The :attribute must be a file',
//     'filled'               => 'The :attribute field must have a value',
//     'image'                => 'The :attribute must be an image',
//     'in'                   => 'The selected :attribute is invalid',
//     'in_array'             => 'The :attribute field does not exist in :other',
//     'integer'              => 'The :attribute must be an integer',
//     'ip'                   => 'The :attribute must be a valid IP address',
//     'ipv4'                 => 'The :attribute must be a valid IPv4 address',
//     'ipv6'                 => 'The :attribute must be a valid IPv6 address',
//     'json'                 => 'The :attribute must be a valid JSON string',
//     'max'                  => [
//         'numeric' => 'The :attribute may not be greater than :max',
//         'file'    => 'The :attribute may not be greater than :max kilobytes',
//         'string'  => 'The :attribute may not be greater than :max characters',
//         'array'   => 'The :attribute may not have more than :max items',
//     ],
//     'mimes'                => 'The :attribute must be a file of type: :values',
//     'mimetypes'            => 'The :attribute must be a file of type: :values',
//     'min'                  => [
//         'numeric' => 'The :attribute must be at least :min',
//         'file'    => 'The :attribute must be at least :min kilobytes',
//         'string'  => 'The :attribute must be at least :min characters',
//         'array'   => 'The :attribute must have at least :min items',
//     ],
//     'not_in'               => 'The selected :attribute is invalid',
//     'numeric'              => 'The :attribute must be a number',
//     'present'              => 'The :attribute field must be present',
//     'regex'                => 'The :attribute format is invalid',
//     'required'             => 'The :attribute field is required',
//     'required_if'          => 'The :attribute field is required when :other is :value',
//     'required_unless'      => 'The :attribute field is required unless :other is in :values',
//     'required_with'        => 'The :attribute field is required when :values is present',
//     'required_with_all'    => 'The :attribute field is required when :values is present',
//     'required_without'     => 'The :attribute field is required when :values is not present',
//     'required_without_all' => 'The :attribute field is required when none of :values are present',
//     'same'                 => 'The :attribute and :other must match',
//     'size'                 => [
//         'numeric' => 'The :attribute must be :size',
//         'file'    => 'The :attribute must be :size kilobytes',
//         'string'  => 'The :attribute must be :size characters',
//         'array'   => 'The :attribute must contain :size items',
//     ],
//     'string'               => 'The :attribute must be a string',
//     'timezone'             => 'The :attribute must be a valid zone',
//     'unique'               => 'The :attribute has already been taken',
//     'uploaded'             => 'The :attribute failed to upload',
//     'url'                  => 'The :attribute format is invalid',

//     /*
//     |--------------------------------------------------------------------------
//     | Custom Validation Language Lines
//     |--------------------------------------------------------------------------
//     |
//     | Here you may specify custom validation messages for attributes using the
//     | convention "attributerule" to name the lines This makes it quick to
//     | specify a specific custom language line for a given attribute rule
//     |
//     */

//     'custom' => [
//         'attribute-name' => [
//             'rule-name' => 'custom-message',
//         ],
//     ],

//     /*
//     |--------------------------------------------------------------------------
//     | Custom Validation Attributes
//     |--------------------------------------------------------------------------
//     |
//     | The following language lines are used to swap attribute place-holders
//     | with something more reader friendly such as E-Mail Address instead
//     | of "email" This simply helps us make messages a little cleaner
//     |
//     */

//     'attributes' => [],

// ];
