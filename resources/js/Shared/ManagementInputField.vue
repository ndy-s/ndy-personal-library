<template>
    <div>
        <label 
            :for="id" 
            class="block mb-2 text-sm text-white dark:text-white"
            :class="{ 
                'text-red-800': form.errors[id], 
                'font-bold': id == 'title_en' || id == 'status' || id == 'type',
            }"
        >
            {{ label }}
        </label>
        <select 
            v-if="id == 'status' || id == 'type'"
            :id="id" 
            :value="form[id]"
            @change="$emit('formValue', $event.target.value)"
            :name="id" 
            class="bg-gray-900 border border-green-400 text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 focus:outline-none block w-full p-2.5" 
            required
        >
            <option value="" selected>{{ placeholder }}</option>
            <option v-for="(option, index) in options" :key="index" :value="option">{{ option }}</option>
        </select>
        <input 
            v-else
            :type="id == 'page' || id == 'video' ? 'number' : 'text'"
            :id="id" 
            :value="form[id]"
            @input="$emit('formValue', $event.target.value)"
            :name="id" 
            class="bg-gray-900 border border-green-400 text-white text-sm rounded-md focus:ring-green-100 focus:border-green-100 focus:outline-none block w-full p-2.5" 
            :class="{'placeholder-red-500 border-red-500': form.errors[id]}" 
            :placeholder="placeholder"
            :min="id == 'page' || id == 'video' ? 0 : null"
            :max="id == 'page' || id == 'video' ? 2000 : null"
            :required="id =='title_en'"
        >
        <div
            v-if="form.errors[id]"
            v-text="form.errors[id]"
            class="text-red-500 text-sm mt-1"
        >
        </div>
    </div>
</template>

<script setup>
    const props = defineProps({
        form: Object,
        id: String,
        label: String,
        placeholder: String,
        options: Array,
    });
</script>