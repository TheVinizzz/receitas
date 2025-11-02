<template>
  <div class="min-h-[calc(100vh-4rem)] bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
      <div v-if="loading" class="flex justify-center items-center py-20">
        <Loader2 :size="40" class="animate-spin text-orange-600" />
      </div>

      <div v-else-if="error" class="flex items-start space-x-3 p-4 bg-red-50 border border-red-200 rounded-xl">
        <AlertCircle :size="20" class="text-red-600 flex-shrink-0 mt-0.5" />
        <span class="text-sm text-red-800">{{ error }}</span>
      </div>

      <div v-else>
        <div class="mb-6">
          <button 
            @click="$router.back()" 
            class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 transition-colors mb-4"
          >
            <ArrowLeft :size="20" />
            <span>Voltar</span>
          </button>
        </div>

        <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 pb-6 border-b border-gray-200">
            <div>
              <h1 class="text-4xl font-bold text-gray-900 mb-3">{{ recipe.nome }}</h1>
              <div class="flex items-center space-x-2 text-gray-600">
                <Tag :size="18" class="text-orange-500" />
                <span class="font-medium">{{ recipe.categoria?.nome || 'Sem categoria' }}</span>
              </div>
            </div>
            
            <div class="flex gap-2">
              <button
                @click="handlePrint"
                class="flex items-center space-x-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-medium"
              >
                <Printer :size="20" />
                <span>Imprimir</span>
              </button>

              <router-link
                :to="`/recipes/${recipe.id}/edit`"
                class="flex items-center space-x-2 px-4 py-2 bg-orange-50 hover:bg-orange-100 text-orange-600 rounded-lg transition-colors font-medium"
              >
                <Pencil :size="20" />
                <span>Editar</span>
              </router-link>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-5">
              <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                  <Clock :size="24" class="text-orange-600" />
                </div>
                <div>
                  <p class="text-sm text-gray-600 font-medium">Tempo de Preparo</p>
                  <p class="text-2xl font-bold text-gray-900">{{ recipe.tempo_preparo_minutos }} min</p>
                </div>
              </div>
            </div>

            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-5">
              <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm">
                  <Users :size="24" class="text-red-600" />
                </div>
                <div>
                  <p class="text-sm text-gray-600 font-medium">Porções</p>
                  <p class="text-2xl font-bold text-gray-900">{{ recipe.porcoes }} {{ recipe.porcoes > 1 ? 'porções' : 'porção' }}</p>
                </div>
              </div>
            </div>
          </div>

          <div class="space-y-8">
            <div>
              <div class="flex items-center space-x-2 mb-4">
                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                  <ListChecks :size="18" class="text-white" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Ingredientes</h2>
              </div>
              <div class="bg-gray-50 rounded-xl p-6">
                <pre class="whitespace-pre-wrap font-sans text-gray-700 leading-relaxed">{{ recipe.ingredientes }}</pre>
              </div>
            </div>

            <div>
              <div class="flex items-center space-x-2 mb-4">
                <div class="w-8 h-8 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                  <FileText :size="18" class="text-white" />
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Modo de Preparo</h2>
              </div>
              <div class="bg-gray-50 rounded-xl p-6">
                <pre class="whitespace-pre-wrap font-sans text-gray-700 leading-relaxed">{{ recipe.modo_preparo }}</pre>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { ArrowLeft, Tag, Clock, Users, Printer, Pencil, ListChecks, FileText, AlertCircle, Loader2 } from 'lucide-vue-next';

export default {
  name: 'RecipeView',
  components: {
    ArrowLeft,
    Tag,
    Clock,
    Users,
    Printer,
    Pencil,
    ListChecks,
    FileText,
    AlertCircle,
    Loader2
  },
  setup() {
    const route = useRoute();
    const router = useRouter();
    const recipe = ref(null);
    const loading = ref(true);
    const error = ref('');

    const fetchRecipe = async () => {
      try {
        const response = await axios.get(`/api/receitas/${route.params.id}`);
        recipe.value = response.data;
      } catch (err) {
        error.value = 'Erro ao carregar receita';
      } finally {
        loading.value = false;
      }
    };

    const handlePrint = () => {
      window.open(`/receitas/${recipe.value.id}/print`, '_blank');
    };

    onMounted(() => {
      fetchRecipe();
    });

    return {
      recipe,
      loading,
      error,
      handlePrint,
    };
  },
};
</script>
