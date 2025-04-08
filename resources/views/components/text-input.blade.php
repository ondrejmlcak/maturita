@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-black dark:border-black dark:bg-black dark:text-white focus:border-white dark:focus:border-white focus:ring-white dark:focus:ring-white rounded-md shadow-sm']) }}>
