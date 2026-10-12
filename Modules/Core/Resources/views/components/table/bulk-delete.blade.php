@props([
    'action',
    'formId',
    'inputName' => 'ids[]',
    'buttonLabel' => __('Delete selected'),
    'selectedLabel' => __('selected'),
])

<div x-data="{
    selectedCount: 0,
    updateSelection() {
        this.selectedCount = Array.from(document.querySelectorAll('input[type=checkbox]'))
            .filter((item) => item.form?.id === '{{ $formId }}' && item.name === '{{ $inputName }}' && item.checked)
            .length;
    },
    selectAll(checked) {
        Array.from(document.querySelectorAll('input[type=checkbox]'))
            .filter((item) => item.form?.id === '{{ $formId }}' && item.name === '{{ $inputName }}')
            .forEach((item) => {
            item.checked = checked;
        });
        this.updateSelection();
    }
}">
    <div class="flex justify-end gap-3 px-5 py-3" x-show="selectedCount > 0" x-cloak>
        <span class="self-center text-sm text-gray-500 dark:text-gray-400" x-text="`${selectedCount} {{ $selectedLabel }}`"></span>
        <form id="{{ $formId }}" method="POST" action="{{ $action }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">
                {{ $buttonLabel }}
            </button>
        </form>
    </div>

    {{ $slot }}
</div>
