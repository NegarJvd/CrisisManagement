<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
