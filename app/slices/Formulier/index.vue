<script setup lang="ts">
import type { Content } from "@prismicio/client";
import { ref, onMounted } from "vue";

defineProps(getSliceComponentProps<Content.FormulierSlice>());

const name = ref("");
const email = ref("");
const subject = ref("");
const date = ref("");
const postcode = ref("");
const straatnaam = ref("");
const huisnummer = ref("");
const telefoonnummer = ref("");
const message = ref("");

// Feedback states
const successMessage = ref("");
const errorMessages = ref<Record<string, string>>({});
const showSuccessPopup = ref(false);

// Auto-set date to today
onMounted(() => {
  const today = new Date().toISOString().split('T')[0];
  date.value = today;
})

const validateForm = () => {
  errorMessages.value = {};
  const postcodePattern = /^\d{4}[A-Za-z]{0,2}$/;
  
  if (!name.value.trim()) errorMessages.value.name = "Naam is verplicht";
  if (name.value.includes("@")) errorMessages.value.name = "@ is niet toegestaan";
  if (!email.value.trim()) errorMessages.value.email = "Email is verplicht";
  if (!subject.value.trim()) errorMessages.value.subject = "Onderwerp is verplicht";
  if (!String(postcode.value).trim()) {
    errorMessages.value.postcode = "Postcode is verplicht";
  } else if (!postcodePattern.test(String(postcode.value).trim())) {
    errorMessages.value.postcode = "Postcode moet 4 cijfers en max 2 letters bevatten (bijv. 1234AB)";
  }
  if (!straatnaam.value.trim()) errorMessages.value.straatnaam = "Straatnaam is verplicht";
  if (straatnaam.value.includes("@")) errorMessages.value.straatnaam = "@ is niet toegestaan";
  if (!huisnummer.value.trim()) errorMessages.value.huisnummer = "Huisnummer is verplicht";
  if (huisnummer.value.includes("@")) errorMessages.value.huisnummer = "@ is niet toegestaan";
  if (!String(telefoonnummer.value).trim()) errorMessages.value.phone_number = "Telefoonnummer is verplicht";
  if (telefoonnummer.value.includes("@")) errorMessages.value.phone_number = "@ is niet toegestaan";
  if (!message.value.trim()) errorMessages.value.message = "Bericht is verplicht";
  if (message.value.includes("@")) errorMessages.value.message = "@ is niet toegestaan";
  
  return Object.keys(errorMessages.value).length === 0;
}

const scrollToError = () => {
  setTimeout(() => {
    const firstErrorField = document.querySelector('[data-error="true"]');
    if (firstErrorField) {
      firstErrorField.scrollIntoView({ behavior: 'smooth', block: 'center' });
      (firstErrorField as HTMLInputElement).focus();
    }
  }, 100);
}

const resetForm = () => {
  name.value = "";
  email.value = "";
  subject.value = "";
  postcode.value = "";
  straatnaam.value = "";
  huisnummer.value = "";
  telefoonnummer.value = "";
  message.value = "";
  errorMessages.value = {};
  
  const today = new Date().toISOString().split('T')[0];
  date.value = today;
}

const sanitizeName = (value: string) => value.replace(/[^A-Za-zÀ-ÿ\s-]/g, "");
const sanitizeStreet = (value: string) => value.replace(/[^A-Za-zÀ-ÿ\s-]/g, "");
const sanitizeHouseNumber = (value: string) => value.replace(/[^A-Za-z0-9]/g, "");
const sanitizePhone = (value: string | number) => String(value).replace(/[^0-9]/g, "");
const sanitizePostcode = (value: string) => value.replace(/[^0-9A-Za-z]/g, "").toUpperCase();
const sanitizeMessage = (value: string) => value.replace(/[^A-Za-zÀ-ÿ0-9\s.,!?-]/g, "");

const submitForm = async () => {
  if (!validateForm()) {
    scrollToError();
    return;
  }

  try {
    const res = await fetch('http://localhost:8000/api/forms', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        name: name.value,
        email: email.value,
        subject: subject.value,
        date: date.value,
        postcode: postcode.value,
        straatnaam: straatnaam.value,
        huisnummer: huisnummer.value,
        phone_number: telefoonnummer.value,
        message: message.value,
      }),
    })

    if (!res.ok) {
      const errors = await res.json();
      if (errors.errors) {
        errorMessages.value = errors.errors;
      }
      scrollToError();
      return;
    }

    successMessage.value = "Formulier succesvol verzonden!";
    showSuccessPopup.value = true;
    resetForm();
    
    setTimeout(() => {
      showSuccessPopup.value = false;
    }, 5000);
    
  } catch (error) {
    console.error('Error:', error);
    errorMessages.value.submit = "Er is een fout opgetreden. Probeer later opnieuw.";
  }
}



</script>

<template>
  <section>
    <div class="formcontainer">
      <h2 class="formheader">{{ slice.primary.formheader }} </h2>

      <!-- Success Popup -->
      <div v-if="showSuccessPopup" class="success-popup">
        <div class="popup-content">
          <h3>✓ {{ successMessage }}</h3>
          <p>Het formulier is succesvol verzonden.</p>
        </div>
      </div>

      <!-- General Error Message -->
      <div v-if="errorMessages.submit" class="error-banner">
        {{ errorMessages.submit }}
      </div>

      <form>
        <!-- Name -->
        <div :data-error="!!errorMessages.name">
          <p>*Name</p>
          <input v-model="name" @input="name = sanitizeName(name)" placeholder="Voer uw naam in" label="Name" required/>
          <span v-if="errorMessages.name" class="error-text">{{ errorMessages.name }}</span>
        </div>

        <!-- Email -->
        <div :data-error="!!errorMessages.email">
          <p>*Email</p>
          <input type="email" v-model="email" placeholder="Voer uw email in" label="Email" required/>
          <span v-if="errorMessages.email" class="error-text">{{ errorMessages.email }}</span>
        </div>

        <!-- Onderwerp -->
        <div :data-error="!!errorMessages.subject">
          <p>*Onderwerp</p>
          <select v-model="subject">
            <option disabled selected value="">Selecteer Onderwerp</option>
            <option>Technisch Probleem</option>
            <option>Vragen</option>
            <option>Overig</option>
          </select>
          <span v-if="errorMessages.subject" class="error-text">{{ errorMessages.subject }}</span>
        </div>

        <!-- Date -->
        <p>Date</p>
        <input type="date" v-model.lazy="date" label="Date" readonly required/>

        <!-- Postcode -->
        <div :data-error="!!errorMessages.postcode">
          <p>*Postcode</p>
          <input
            type="text"
            v-model="postcode"
            @input="postcode = sanitizePostcode(postcode)"
            placeholder="Bijv. 1234AB"
            label="Postcode"
            maxlength="6"
            pattern="[0-9]{4}[A-Za-z]{0,2}"
            title="Postcode moet 4 cijfers en max 2 letters bevatten (bijv. 1234AB)"
            autocomplete="postal-code"
            required
          />
          <span v-if="errorMessages.postcode" class="error-text">{{ errorMessages.postcode }}</span>
        </div>

        <!-- Straatnaam -->
        <div :data-error="!!errorMessages.straatnaam">
          <p>*Straatnaam</p>
          <input v-model="straatnaam" @input="straatnaam = sanitizeStreet(straatnaam)" placeholder="Voer uw straatnaam in" label="Straatnaam" required/>
          <span v-if="errorMessages.straatnaam" class="error-text">{{ errorMessages.straatnaam }}</span>
        </div>

        <!-- Huisnummer -->
        <div :data-error="!!errorMessages.huisnummer">
          <p>*Huisnummer</p>
          <input type="text" v-model="huisnummer" @input="huisnummer = sanitizeHouseNumber(huisnummer)" placeholder="Voer uw huisnummer in (bijv. 12a)" label="Huisnummer" required/>
          <span v-if="errorMessages.huisnummer" class="error-text">{{ errorMessages.huisnummer }}</span>
        </div>

        <!-- Telefoonnummer -->
        <div :data-error="!!errorMessages.phone_number">
          <p>*Telefoonnummer</p>
          <input type="number" v-model="telefoonnummer" @input="telefoonnummer = sanitizePhone(telefoonnummer)" placeholder="Voer uw telefoonnummer in" label="Telefoonnummer" required/>
          <span v-if="errorMessages.phone_number" class="error-text">{{ errorMessages.phone_number }}</span>
        </div>

        <!-- Message -->
        <div :data-error="!!errorMessages.message">
          <p>*Beschrijf uw probleem</p>
          <textarea v-model="message" @input="message = sanitizeMessage(message)" placeholder="Voer uw bericht in" label="Message"></textarea>
          <span v-if="errorMessages.message" class="error-text">{{ errorMessages.message }}</span>
        </div>

        <h2>* Verplichte velden</h2>
        <button type="submit" @click.prevent="submitForm">Submit</button>
      </form>
    </div>
  </section>
</template>


<style scoped>

section {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.formcontainer {
  display: flex;
  flex-direction: column;
  width: 50%;
  padding: 2rem;
  border: 2px solid #e2e8f0;
  border-radius: 0.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
  background-color: #f9fafb;
}

.formheader {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 1rem;
  color: #1a202c;
  align-self: center;
}

form p {
  font-size: 1.2rem;
  font-weight: 600;
  margin-top: 1rem;
  margin-bottom: 0.5rem;
  color: #000000; 
}

/* Success Popup */
.success-popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #10b981;
  color: white;
  padding: 2rem;
  border-radius: 0.5rem;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
  z-index: 1000;
  text-align: center;
  animation: slideIn 0.3s ease-out;
}

.success-popup h3 {
  margin: 0;
  font-size: 1.5rem;
}

.success-popup p {
  margin: 0.5rem 0 0 0;
  font-size: 1rem;
}

@keyframes slideIn {
  from {
    opacity: 0;
    transform: translate(-50%, -60%);
  }
  to {
    opacity: 1;
    transform: translate(-50%, -50%);
  }
}

/* Error Banner */
.error-banner {
  background: #f87171;
  color: white;
  padding: 1rem;
  border-radius: 0.5rem;
  margin-bottom: 1rem;
  text-align: center;
  font-weight: 600;
}

/* Error Text */
.error-text {
  color: #dc2626;
  font-size: 0.875rem;
  display: block;
  margin-top: 0.25rem;
}

/* Highlight field with error */
[data-error="true"] input,
[data-error="true"] select,
[data-error="true"] textarea {
  border: 2px solid #dc2626 !important;
  background-color: #fef2f2;
}

input, select, textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #cbd5e0;
  border-radius: 0.375rem;
  font-size: 1rem;
  color: #4a5568;
  box-sizing: border-box;
}

button {
  width: 100%;
  margin-top: 1.5rem;
  padding: 0.75rem 1.5rem;
  background-color: #3b82f6;
  color: white;
  font-size: 1.125rem;
  font-weight: 600;
  border: 2px solid #194c9f;
  border-radius: 0.5rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:hover {
  background-color: #2563eb;
}
</style>