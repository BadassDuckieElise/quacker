<script setup lang="ts">
import type { Content } from "@prismicio/client";
import { ref, onMounted } from "vue";

const props = defineProps(getSliceComponentProps<Content.ContactformSlice>());

const isModalOpen = ref(false);
const selectedItem = ref<any>(null);

// Debug: Log the slice data to see what we're getting
onMounted(() => {
  console.log("Slice data:", props.slice);
  console.log("Shop items:", props.slice.primary.shopdisplay);
  if (props.slice.primary.shopdisplay.length > 0) {
    console.log("First item:", props.slice.primary.shopdisplay[0]);
  }
});

const openModal = (item: any) => {
  console.log("Opening modal with item:", item);
  selectedItem.value = item;
  isModalOpen.value = true;
  // Prevent body scroll when modal is open
  document.body.style.overflow = "hidden";
};

const closeModal = () => {
  isModalOpen.value = false;
  selectedItem.value = null;
  document.body.style.overflow = "";
};

const handleBuyClick = () => {
  alert("This is a test button - no actual purchase functionality!");
};
</script>

<template>
  <section
    :data-slice-type="slice.slice_type"
    :data-slice-variation="slice.variation"
    class="shop-display"
  >
    <div class="shop-container">
      <div class="shop-grid">
        <div
          v-for="(item, index) in slice.primary.shopdisplay"
          :key="index"
          class="shop-item"
        >
          <div class="shop-item-card" @click="openModal(item)">
            <div class="shop-item-image">
              <PrismicImage
                v-if="item.shopimg"
                :field="item.shopimg"
                class="item-img"
              />
            </div>
            <div class="shop-item-info">
              <h3 class="item-name">{{ item.item }}</h3>
              <span class="click-hint">Click for details</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <Teleport to="body">
      <Transition name="modal">
        <div v-if="isModalOpen" class="modal-overlay" @click="closeModal">
          <div class="modal-content" @click.stop>
            <button class="modal-close" @click="closeModal" aria-label="Close modal">
              ×
            </button>
            
            <div v-if="selectedItem" class="modal-body">
              <div class="modal-image">
                <PrismicImage
                  v-if="selectedItem.shopimg"
                  :field="selectedItem.shopimg"
                  class="modal-img"
                />
              </div>
              
              <div class="modal-details">
                <h2 class="modal-title">{{ selectedItem.item }}</h2>
                
                <div class="modal-description">
                  <PrismicRichText
                    v-if="selectedItem.description"
                    :field="selectedItem.description"
                  />
                  <p v-else>No description available.</p>
                </div>
                
                <button class="buy-button" @click="handleBuyClick">
                  {{ selectedItem.buttontext || "Buy Now" }}
                </button>
              </div>
            </div>
          </div>
        </div>
      </Transition>
    </Teleport>
  </section>
</template>

<style scoped>
.shop-display {
  padding: 4rem 2rem;
  background: #f9fafb;
}

.shop-container {
  max-width: 1200px;
  margin: 0 auto;
}

.shop-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 2rem;
}

.shop-item-card {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.shop-item-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.shop-item-image {
  width: 100%;
  height: 250px;
  overflow: hidden;
  background: #f0f0f0;
}

.item-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.shop-item-card:hover .item-img {
  transform: scale(1.05);
}

.shop-item-info {
  padding: 1.5rem;
  text-align: center;
}

.item-name {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0 0 0.5rem;
}

.click-hint {
  font-size: 0.875rem;
  color: #6b7280;
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.7);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 1rem;
}

.modal-content {
  background: white;
  border-radius: 16px;
  max-width: 900px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-close {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  font-size: 2rem;
  line-height: 1;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10;
  transition: background 0.2s ease;
}

.modal-close:hover {
  background: rgba(0, 0, 0, 0.7);
}

.modal-body {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 2rem;
  padding: 2rem;
}

.modal-image {
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f9fafb;
  border-radius: 12px;
  overflow: hidden;
  min-height: 400px;
}

.modal-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.modal-details {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.modal-title {
  font-size: 2rem;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
}

.modal-description {
  flex: 1;
  color: #4b5563;
  line-height: 1.6;
}

.buy-button {
  background: #3b82f6;
  color: white;
  border: none;
  border-radius: 8px;
  padding: 1rem 2rem;
  font-size: 1.125rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.2s ease, transform 0.1s ease;
}

.buy-button:hover {
  background: #2563eb;
  transform: translateY(-2px);
}

.buy-button:active {
  transform: translateY(0);
}

/* Modal Transitions */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-active .modal-content,
.modal-leave-active .modal-content {
  transition: transform 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-content,
.modal-leave-to .modal-content {
  transform: scale(0.9);
}

/* Responsive Design */
@media (max-width: 768px) {
  .shop-grid {
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
  }

  .modal-body {
    grid-template-columns: 1fr;
    padding: 1.5rem;
  }

  .modal-image {
    min-height: 300px;
  }

  .modal-title {
    font-size: 1.5rem;
  }
}
</style>
