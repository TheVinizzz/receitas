<template>
  <div class="min-h-[calc(100vh-4rem)] bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
      <div class="mb-6">
        <button 
          @click="$router.back()" 
          class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors mb-4"
        >
          <ArrowLeft :size="20" />
          <span>Voltar</span>
        </button>
        
        <h1 class="text-3xl font-bold text-gray-900 flex items-center space-x-3">
          <Pencil :size="32" class="text-orange-600" />
          <span>Editar Receita</span>
        </h1>
        <p class="text-gray-600 mt-1">Atualize as informações da sua receita</p>
      </div>

      <div v-if="loadingRecipe" class="flex justify-center items-center py-20">
        <Loader2 :size="40" class="animate-spin text-orange-600" />
      </div>

      <div v-else class="bg-white rounded-xl shadow-md p-8">
        <form @submit.prevent="handleSubmit" class="space-y-6">
          <div v-if="error" class="flex items-start space-x-3 p-4 bg-red-50 border border-red-200 rounded-xl">
            <AlertCircle :size="20" class="text-red-600 flex-shrink-0 mt-0.5" />
            <span class="text-sm text-red-800">{{ error }}</span>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="nome">
              Nome da Receita
            </label>
            <input
              id="nome"
              v-model="form.nome"
              type="text"
              required
              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
              placeholder="Ex: Bolo de Chocolate"
            >
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2" for="id_categorias">
                <div class="flex items-center space-x-2">
                  <Tag :size="16" />
                  <span>Categoria</span>
                </div>
              </label>
              <select
                id="id_categorias"
                v-model="form.id_categorias"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
              >
                <option value="">Selecione...</option>
                <option v-for="categoria in categorias" :key="categoria.id" :value="categoria.id">
                  {{ categoria.nome }}
                </option>
              </select>
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2" for="tempo_preparo_minutos">
                <div class="flex items-center space-x-2">
                  <Clock :size="16" />
                  <span>Tempo (min)</span>
                </div>
              </label>
              <input
                id="tempo_preparo_minutos"
                v-model.number="form.tempo_preparo_minutos"
                type="number"
                min="1"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                placeholder="30"
              >
            </div>

            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2" for="porcoes">
                <div class="flex items-center space-x-2">
                  <Users :size="16" />
                  <span>Porções</span>
                </div>
              </label>
              <input
                id="porcoes"
                v-model.number="form.porcoes"
                type="number"
                min="1"
                required
                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all"
                placeholder="4"
              >
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="ingredientes">
              <div class="flex items-center space-x-2">
                <ListChecks :size="16" />
                <span>Ingredientes</span>
              </div>
            </label>
            <textarea
              id="ingredientes"
              v-model="form.ingredientes"
              required
              rows="6"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all resize-none"
              placeholder="Liste os ingredientes, um por linha"
            ></textarea>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2" for="modo_preparo">
              <div class="flex items-center space-x-2">
                <FileText :size="16" />
                <span>Modo de Preparo</span>
              </div>
            </label>
            <textarea
              id="modo_preparo"
              v-model="form.modo_preparo"
              required
              rows="8"
              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all resize-none"
              placeholder="Descreva o modo de preparo passo a passo"
            ></textarea>
          </div>

          <div class="flex gap-3 pt-4">
            <button
              type="button"
              @click="$router.back()"
              class="flex-1 flex items-center justify-center space-x-2 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl transition-colors font-semibold"
            >
              <X :size="20" />
              <span>Cancelar</span>
            </button>
            
            <button
              type="submit"
              :disabled="loading"
              class="flex-1 flex items-center justify-center space-x-2 px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-xl hover:from-orange-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl font-semibold disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <Loader2 v-if="loading" :size="20" class="animate-spin" />
              <Save v-else :size="20" />
              <span>{{ loading ? 'Salvando...' : 'Salvar Alterações' }}</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import { Pencil, ArrowLeft, Tag, Clock, Users, ListChecks, FileText, AlertCircle, X, Save, Loader2 } from 'lucide-vue-next';

export default {
  name: 'RecipeEdit',
  components: {
    Pencil,
    ArrowLeft,
    Tag,
    Clock,
    Users,
    ListChecks,
    FileText,
    AlertCircle,
    X,
    Save,
    Loader2
  },
  setup() {
    const router = useRouter();
    const route = useRoute();
    const categorias = ref([]);
    const error = ref('');
    const loading = ref(false);
    const loadingRecipe = ref(true);
    
    const form = ref({
      nome: '',
      id_categorias: '',
      tempo_preparo_minutos: '',
      porcoes: '',
      ingredientes: '',
      modo_preparo: '',
    });

    const fetchCategorias = async () => {
      try {
        const response = await axios.get('/api/categorias');
        categorias.value = response.data;
      } catch (err) {
        console.error('Erro ao carregar categorias:', err);
      }
    };

    const fetchRecipe = async () => {
      try {
        const response = await axios.get(`/api/receitas/${route.params.id}`);
        form.value = {
          nome: response.data.nome,
          id_categorias: response.data.id_categorias,
          tempo_preparo_minutos: response.data.tempo_preparo_minutos,
          porcoes: response.data.porcoes,
          ingredientes: response.data.ingredientes,
          modo_preparo: response.data.modo_preparo,
        };
      } catch (err) {
        error.value = 'Erro ao carregar receita';
      } finally {
        loadingRecipe.value = false;
      }
    };

    const handleSubmit = async () => {
      error.value = '';
      loading.value = true;
      
      try {
        await axios.put(`/api/receitas/${route.params.id}`, form.value);
        router.push('/recipes');
      } catch (err) {
        error.value = err.response?.data?.message || 'Erro ao atualizar receita';
      } finally {
        loading.value = false;
      }
    };

    onMounted(async () => {
      await fetchCategorias();
      await fetchRecipe();
    });

    return {
      form,
      categorias,
      error,
      loading,
      loadingRecipe,
      handleSubmit,
    };
  },
};
</script>
