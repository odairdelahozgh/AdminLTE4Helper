<?php
declare(strict_types=1);
namespace AdminLTE\Components;

class Form {

    /**
     * Genera un campo de input completo (label, input, help text, error).
     */
    public static function input(string $name, string $label, array $options = []): string
    {
        $defaultOptions = [
            'type' => 'text',
            'value' => '',
            'placeholder' => '',
            'help_text' => '',
            'id' => null,
            'error' => null,
            // Para 'range'
            'min' => null,
            'max' => null,
            'step' => null,
        ];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'form-' . $name;

        $isInvalidClass = $options['error'] ? ' is-invalid' : '';
        $controlClass = 'form-control';

        if ($options['type'] === 'range') {
            $controlClass = 'form-range';
        } elseif ($options['type'] === 'file') {
            // Bootstrap file input doesn't need a different class here, but the structure is label-input.
        }

        $html = '<div class="mb-3">';
        $html .= '  <label for="' . $id . '" class="form-label">' . htmlspecialchars($label) . '</label>';

        $attributes = [
            'type="' . $options['type'] . '"',
            'class="' . $controlClass . $isInvalidClass . '"',
            'id="' . $id . '"',
            'name="' . $name . '"',
            'value="' . htmlspecialchars($options['value']) . '"',
            'placeholder="' . htmlspecialchars($options['placeholder']) . '"'
        ];

        if ($options['type'] === 'range') {
            if ($options['min'] !== null) $attributes[] = 'min="' . $options['min'] . '"';
            if ($options['max'] !== null) $attributes[] = 'max="' . $options['max'] . '"';
            if ($options['step'] !== null) $attributes[] = 'step="' . $options['step'] . '"';
        }
        
        // For file inputs, the value attribute is not used for security reasons.
        if ($options['type'] === 'file') {
            $attributes = array_filter($attributes, fn($attr) => !str_starts_with($attr, 'value='));
        }


        $html .= '  <input ' . implode(' ', $attributes) . '>';

        if ($options['error']) {
            $html .= '<div class="invalid-feedback">' . htmlspecialchars($options['error']) . '</div>';
        } elseif ($options['help_text']) {
            $html .= '<div class="form-text">' . htmlspecialchars($options['help_text']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un campo de textarea completo.
     */
    public static function textarea(string $name, string $label, array $options = []): string
    {
        $defaultOptions = ['value' => '', 'rows' => 3, 'placeholder' => '', 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'form-' . $name;
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="mb-3">';
        $html .= '  <label for="' . $id . '" class="form-label">' . htmlspecialchars($label) . '</label>';
        $html .= '  <textarea class="form-control' . $isInvalidClass . '" id="' . $id . '" name="' . $name . '" rows="' . $options['rows'] . '" placeholder="' . htmlspecialchars($options['placeholder']) . '">' . htmlspecialchars($options['value']) . '</textarea>';
        if ($options['error']) {
            $html .= '<div class="invalid-feedback">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un campo de select completo.
     */
    public static function select(string $name, string $label, array $selectOptions, array $options = []): string
    {
        $defaultOptions = ['selected_value' => null, 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'form-' . $name;
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="mb-3">';
        $html .= '  <label for="' . $id . '" class="form-label">' . htmlspecialchars($label) . '</label>';
        $html .= '  <select class="form-select' . $isInvalidClass . '" id="' . $id . '" name="' . $name . '">';
        foreach ($selectOptions as $value => $text) {
            $selectedAttr = ($value == $options['selected_value']) ? ' selected' : '';
            $html .= '<option value="' . htmlspecialchars((string) $value) . '"' . $selectedAttr . '>' . htmlspecialchars($text) . '</option>';
        }
        $html .= '  </select>';
        if ($options['error']) {
            $html .= '<div class="invalid-feedback">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Custom Checkbox.
     */
    public static function customCheckbox(string $name, string $label, array $options = []): string
    {
        $defaultOptions = ['value' => '1', 'checked' => false, 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'check-' . uniqid();
        $checkedAttr = $options['checked'] ? 'checked' : '';
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="form-check">';
        $html .= '  <input class="form-check-input' . $isInvalidClass . '" type="checkbox" name="' . $name . '" value="' . htmlspecialchars($options['value']) . '" id="' . $id . '" ' . $checkedAttr . '>';
        $html .= '  <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($label) . '</label>';
        if ($options['error']) {
            $html .= '<div class="invalid-feedback d-block">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Custom Radio button.
     */
    public static function customRadio(string $name, string $label, array $options = []): string
    {
        $defaultOptions = ['value' => '1', 'checked' => false, 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $id = $options['id'] ?? 'radio-' . uniqid();
        $checkedAttr = $options['checked'] ? 'checked' : '';
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="form-check">';
        $html .= '  <input class="form-check-input' . $isInvalidClass . '" type="radio" name="' . $name . '" value="' . htmlspecialchars($options['value']) . '" id="' . $id . '" ' . $checkedAttr . '>';
        $html .= '  <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($label) . '</label>';
        if ($options['error']) {
            // For grouped radios, error might be better handled outside, but let's provide an option.
            $html .= '<div class="invalid-feedback d-block">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Input Group.
     */
    public static function inputGroup(string $name, array $options = []): string
    {
        $defaultOptions = ['type' => 'text', 'placeholder' => '', 'prepend' => null, 'append' => null, 'value' => '', 'error' => null];
        $options = array_merge($defaultOptions, $options);
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="input-group mb-3">';
        if ($options['prepend']) {
            $html .= '<span class="input-group-text">' . $options['prepend'] . '</span>';
        }
        $html .= '<input type="' . $options['type'] . '" name="' . $name . '" class="form-control' . $isInvalidClass . '" placeholder="' . htmlspecialchars($options['placeholder']) . '" value="' . htmlspecialchars($options['value']) . '">';
        if ($options['append']) {
            $html .= '<span class="input-group-text">' . $options['append'] . '</span>';
        }
        if ($options['error']) {
            $html .= '<div class="invalid-feedback">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Genera un Custom Switch.
     */
    public static function customSwitch(string $name, string $label, array $options = []): string
    {
        $defaultOptions = ['checked' => false, 'id' => null, 'error' => null];
        $options = array_merge($defaultOptions, $options);

        $id = $options['id'] ?? 'switch-' . uniqid();
        $checkedAttr = $options['checked'] ? 'checked' : '';
        $isInvalidClass = $options['error'] ? ' is-invalid' : '';

        $html = '<div class="form-check form-switch">';
        $html .= '  <input class="form-check-input' . $isInvalidClass . '" type="checkbox" name="' . $name . '" role="switch" id="' . $id . '" ' . $checkedAttr . '>';
        $html .= '  <label class="form-check-label" for="' . $id . '">' . htmlspecialchars($label) . '</label>';
        if ($options['error']) {
            $html .= '<div class="invalid-feedback d-block">' . htmlspecialchars($options['error']) . '</div>';
        }
        $html .= '</div>';
        return $html;
    }
}
