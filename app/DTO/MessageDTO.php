<?php

namespace App\DTO;

use App\DTO\AbstractDTO;
use Illuminate\Contracts\Validation\Validator;
use stdClass;

class MessageDTO extends AbstractDTO {

    public function __construct(
        public array|null $metadata,
        public array|null $contact,
        public array|null $message,
        public string|null $type
    ) {
        $this->validate();
    }

    public static function makeFromRequest($request): self {

        $data = $request->body['entry'][0]['changes'][0]['value'];

        $parseData = [
            'metadata' => [
                'displayPhone' => $data['metadata']['display_phone_number'],
                'numberID' => $data['metadata']['phone_number_id']
            ],
            'contact' => [
                'name' => $data['contacts'][0]['profile']['name'],
                'phoneWhatsapp' => $data['contacts'][0]['wa_id']
            ],
            'message' => [
                'from' => $data['messages'][0]['from'],
                'idWhatsapp' => $data['messages'][0]['id'],
                'timestamp' => $data['messages'][0]['timestamp'],
                'type' => $data['messages'][0]['type'],
                'text' => $data['messages'][0]['text']['body']
            ]
        ];

        return new self(
            $parseData['metadata'],
            $parseData['contact'],
            $parseData['message'],
            $parseData['message']['type']
        );
    }

    public function rules(): array {
        return [];
        return [
            'cpf' => 'string:min:11|max:11'
        ];
    }

    public function messages(): array {
        return [
            'cpf' => 'CPF inválido'
        ];
    }

    public function validator(): Validator {
        return validator($this->toArray(), $this->rules(), $this->messages());
    }

    public function validate(): array {
        return $this->validator()->validate();
    }

    public static function parseData(stdClass $data): stdClass {
        $dataArray = (array) $data;
        $valuesParsers = $dataArray['fields'];

        $newData = [];
        foreach ($dataArray as $key => $value) {
            if (array_key_exists($key, $valuesParsers)) {
                $newData[$valuesParsers[$key]] = $value;
            }
        }

        return (object) $newData;
    }

    public function parseFields($dtoFields) {
        $fields = $this->toArray();
        if (isset($fields['fields'])) {
            unset($fields['fields']);
        }

        $newFields = [];

        foreach ($fields as $key => $field) {
            $newFields[$dtoFields[$key]] = $field;
        }

        return $newFields;
    }

    public function prepareDataBeforeSave() {
        $data = [];
        foreach ($this->toArray() as $key) {
            if (!is_array($key)) {
                continue;
            }
            foreach ($key as $k => $value) {
                $data[$k] = $value;
            }
        }
        return $data;
    }
}
