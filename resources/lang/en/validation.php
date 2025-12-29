<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'The :attribute confirmation does not match.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field must have a value.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'ipv4'                 => 'The :attribute must be a valid IPv4 address.',
    'ipv6'                 => 'The :attribute must be a valid IPv6 address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'The :attribute must be at least :min characters.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'The :attribute field is required.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'The :attribute has already been taken.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        // Custom validations
        'gr_no' => [
            'unique' => 'This Registration Number is already taken.',
        ],
        'email' => [
            'unique' => 'This email address is already registered.',
        ],
        'phone' => [
            'unique' => 'This phone number is already registered.',
        ],
        'cnic' => [
            'unique' => 'This CNIC is already registered.',
        ],
        'marks' => [
            'numeric' => 'Marks must be a valid number.',
            'max' => 'The obtained marks cannot exceed :max.',
        ],
        'amount' => [
            'numeric' => 'Amount must be a valid number.',
            'gt' => 'Amount must be greater than zero.',
        ],
        'end_date' => [
            'after' => 'The end date must be after the start date.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'name',
        'email' => 'email address',
        'password' => 'password',
        'password_confirmation' => 'password confirmation',
        'phone' => 'phone number',
        'mobile' => 'mobile number',
        'address' => 'address',
        'date_of_birth' => 'date of birth',
        'gr_no' => 'registration number',
        'father_name' => "father's name",
        'mother_name' => "mother's name",
        'guardian_name' => "guardian's name",
        'class_id' => 'class',
        'section_id' => 'section',
        'session_id' => 'academic session',
        'subject_id' => 'subject',
        'exam_id' => 'exam',
        'marks' => 'marks',
        'amount' => 'amount',
        'fee_amount' => 'fee amount',
        'discount' => 'discount',
        'start_date' => 'start date',
        'end_date' => 'end date',
    ],

    // Custom validation messages for controllers
    'name_required' => 'The name field is required.',
    'father_name_required' => "The father's name field is required.",
    'gender_required' => 'The gender field is required.',
    'class_required' => 'The class field is required.',
    'class_numeric' => 'The class must be a valid number.',
    'section_required' => 'The section field is required.',
    'gr_no_required' => 'The registration number (GR No) is required.',
    'gr_no_unique' => 'This registration number (GR No) already exists.',
    'guardian_required' => 'The guardian field is required.',
    'guardian_relation_required' => 'The guardian relation field is required.',
    'tuition_fee_required' => 'The tuition fee field is required.',
    'tuition_fee_numeric' => 'The tuition fee must be a valid number.',
    'dob_required' => 'The date of birth field is required.',
    'doa_required' => 'The date of admission field is required.',
    'doe_required' => 'The date of expiry field is required.',
    'dob_date' => 'The date of birth must be a valid date.',
    'date_of_joining_date' => 'The date of joining must be a valid date.',
    'img_image' => 'The file must be an image.',
    'img_mimes' => 'The image must be a JPG, JPEG, or PNG file.',
    'img_max' => 'The image must not exceed 100 KB.',
    'id_card_unique' => 'This ID card number already exists.',
    'religion_required' => 'The religion field is required.',
    'role_required' => 'The role field is required.',
    'salary_required' => 'The salary field is required.',
    'salary_numeric' => 'The salary must be a valid number.',
    'exam_category_required' => 'The exam category field is required.',
    'description_required' => 'The description field is required.',
    'start_date_required' => 'The start date field is required.',
    'end_date_required' => 'The end date field is required.',
    'vendor_required' => 'The vendor field is required.',
    'voucher_no_required' => 'The voucher number is required.',
    'voucher_date_required' => 'The voucher date is required.',
    'items_required' => 'At least one item is required.',
    'title_required' => 'The title field is required.',
    'notice_required' => 'The notice content is required.',
    'till_date_required' => 'The till date field is required.',
    'numeric_name_required' => 'The numeric name field is required.',
    'prifix_required' => 'The prefix field is required.',
    'type_required' => 'The type field is required.',
    'amount_required' => 'The amount field is required.',
    'amount_numeric' => 'The amount must be a valid number.',
    'date_required' => 'The date field is required.',
    'book_required' => 'The book field is required.',

];
