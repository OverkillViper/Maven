<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

// Reactive variables to store the current date and time parts
const formattedDate = ref('');
const currentTime = ref({
  hour: '',
  minute: '',
  second: '',
  ampm: ''
});

// Function to update the date and time
const updateTime = () => {
  const now = new Date();
  
  // Format the date
  const options = { year: 'numeric', month: 'long', day: '2-digit' };
  formattedDate.value = now.toLocaleDateString('en-US', options);

  // Get the current hours, minutes, and seconds
  let hours = now.getHours();
  const minutes = String(now.getMinutes()).padStart(2, '0');
  const seconds = String(now.getSeconds()).padStart(2, '0');
  const ampm = hours >= 12 ? 'PM' : 'AM';
  
  // Convert to 12-hour format
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  
  // Update the time parts
  currentTime.value.hour = String(hours).padStart(2, '0');
  currentTime.value.minute = minutes;
  currentTime.value.second = seconds;
  currentTime.value.ampm = ampm;
};

let interval = null;

onMounted(() => {
  updateTime();
  interval = setInterval(updateTime, 1000);
});

onUnmounted(() => {
  clearInterval(interval);
});
</script>

<template>

    <div class="bg-gray-100 rounded-lg p-4 px-8 shadow-sm shadow-gray-300">
        <div class="flex items-center">
            <div>
                <span class="material-symbols-outlined text-5xl">
                    nest_clock_farsight_analog
                </span>
            </div>
            <div class="w-64">
                <div class="font-semibold text-end">{{ formattedDate }}</div>
                <div class="text-end text-2xl font-bold mt-1">{{ currentTime.hour }} : {{ currentTime.minute }} : {{ currentTime.second }} {{ currentTime.ampm }}</div>
                <div></div>
            </div>
        </div>
        
    </div>
    
</template>