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
        'holidies.type' => [
            'required' => '請選擇假日類型',
        ],
        'holidies.name' => [
            'required' => '請輸入假日名稱',
            'max' => '最長為10個字,請縮減長度',
        ],
        'holidies.date' => [
            'required' => '請選擇日期',
            'date' => '請填入正確的日期格式',
            'unique' => '該日期已經有假日囉~',
        ],
	    'leave_type.name' => [
            'required' => '請輸入假別名稱',
        ],
        'leave_type.hours' => [
            'required' => '請輸入時間上限',
            'numeric' => '時間上限僅限數字',
        ],
        'leave_type.exception' => [
            'required' => '至少選取一項類型',
        ],
        'leave_type.reset_time' => [
            'required' => '至少選取一項重置的時間',
        ],
        'leave_type.start_time' => [
            'Date' => '開始時間請填入日期',
        ],
        'leave_type.end_time' => [
            'Date' => '結束時間請填入日期',
        ],
        'user.role' => [
            'required' => '請選擇員工權限',
            'in' => '員工權限錯誤',
        ],
        'user.status' => [
            'required' => '請選擇員工狀態',
            'numeric' => '員工狀態僅限數字',
            'in' => '員工狀態錯誤',
        ],
        'user.employee_no' => [
            'required' => '請輸入員工編號',
            'numeric' => '員工編號僅限數字',
            'digits_between' => '員工編號最多7碼',
        ],
        'user.name' => [
            'required' => '請輸入姓名',
            'string' => '姓名請填入字串',
            'max' => '姓名最大20字元',
        ],
        'user.nickname' => [
            'required' => '請輸入稱呼',
            'string' => '稱呼請填入字串',
            'max' => '稱呼最大20字元',
        ],
        'user.birthday' => [
            'required' => '請輸入生日',
            'Date' => '生日請填入日期',
        ],
        'user.enter_date' => [
            'required' => '請輸入到職時間',
            'Date' => '到職時間請填入日期',
        ],
        'user.leave_date' => [
            'Date' => '離職時間請填入日期',
        ],
        'user.avatar' => [
            'image' => '大頭貼請選擇圖片',
        ],
        'user.arrive_time' => [
            'required' => '請選擇上班時間',
            'in' => '上班時間錯誤',
        ],
        'leave.type_id' => [
            'required' => '至少勾選一項',
        ],
        'leave.timepicker' => [
            'required' => '請選擇請假時間',
        ],
        'leave.agent' => [
            'required' => '請選擇代理人，若無代理人請洽HR',
        ],
	'daily.items' => [
            'required' => '請填寫標題',
            'regex' => '標題請不要輸入全形空白',
            'max' => '標題不可超過100字元',
        ],
        'daily.working_day' => [
            'required' => '請填工作日期',
            'date' => '請填正確日期',
        ],
        'daily.project_id' => [
            'required' => '請填專案名稱',
            'numeric' => '專案名稱只能是數字',
        ],
        'daily.hour' => [
            'required' => '請填工作時數',
            'numeric' => '工作時數必須為數字',
            'min' => '請填選正確時數',
        ],
        'sheet_project.title' => [
            'required' => '專案項目必填',
        ],
        'sheet_project.team' => [
            'required' => '團隊必選',
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

    'attributes' => [],

];
