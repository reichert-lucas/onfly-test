<template>
    <v-dialog
        :model-value="show"
        @input="$emit('update:modelValue', $event.target.value)"
        persistent
        width="800"
    >
        <v-card elevation="5" shaped>
            <v-form @submit.prevent="save()" ref="form">
                <v-container>
                    <v-card-title class="mb-6">{{ order ? 'Editar' : 'Cadastrar' }} Pedido de Viagem</v-card-title>
        
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    label="Destino"
                                    v-model="destination.value.value"
                                    :error-messages="destination.errorMessage.value"
                                    placeholder="Digite o destino da viagem"
                                />
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-text-field
                                    label="Data de Ida"
                                    v-model="departure_date.value.value"
                                    :error-messages="departure_date.errorMessage.value"
                                    placeholder="DD/MM/AAAA"
                                    v-maska:[dateMask]
                                    prepend-icon="mdi-calendar"
                                />
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-text-field
                                    label="Data de Volta"
                                    v-model="return_date.value.value"
                                    :error-messages="return_date.errorMessage.value"
                                    placeholder="DD/MM/AAAA"
                                    v-maska:[dateMask]
                                    prepend-icon="mdi-calendar"
                                />
                            </v-col>
                        </v-row>
                    </v-card-text>
                
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            class="text-none font-weight-black"
                            variant="flat"
                            @click="() => {
                                close()
                                $emit('close')
                            }"
                        >
                            cancelar
                        </v-btn>
                        <v-btn
                            class="text-none font-weight-black"
                            color="blue"
                            variant="tonal"
                            size="large"
                            type="submit"
                        >
                            Salvar
                        </v-btn>
                    </v-card-actions>
                </v-container>
            </v-form>
        </v-card>
    </v-dialog>
</template>

<script setup>
import { useField, useForm } from 'vee-validate'
import { watch } from 'vue';

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    }
})

const emit = defineEmits(['close', 'refreshOrders'])

const { handleSubmit, handleReset } = useForm({
    validationSchema: {
        destination (value) {
            if (!value) return 'O campo destino é obrigatório';
            if (value.length < 3) return 'O destino deve ter pelo menos 3 caracteres';
            return true
        },

        departure_date (value) {
            if (!value) return 'A data de ida é obrigatória';
            const dateRegex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;
            if (!dateRegex.test(value)) return 'Formato de data inválido (DD/MM/AAAA)';
            
            const [day, month, year] = value.split('/');
            const inputDate = new Date(year, month - 1, day);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            if (inputDate < today) return 'A data de ida deve ser hoje ou uma data futura';
            
            return true
        },

        return_date (value) {
            if (!value) return 'A data de volta é obrigatória';
            const dateRegex = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4}$/;
            if (!dateRegex.test(value)) return 'Formato de data inválido (DD/MM/AAAA)';
            
            if (departure_date.value.value) {
                const [depDay, depMonth, depYear] = departure_date.value.value.split('/');
                const [retDay, retMonth, retYear] = value.split('/');
                
                const departureDate = new Date(depYear, depMonth - 1, depDay);
                const returnDate = new Date(retYear, retMonth - 1, retDay);
                
                if (returnDate < departureDate) return 'A data de volta deve ser posterior ou igual data de ida';
            }
            
            return true
        }
    },
})

const destination = useField('destination');
const departure_date = useField('departure_date');
const return_date = useField('return_date');

const dateMask = { mask: '##/##/####' };

const formatDateForAPI = (dateString) => {
    if (!dateString) return null;
    const [day, month, year] = dateString.split('/');
    return `${year}-${month}-${day}`;
}

const save = handleSubmit(values => {
    const formData = {
        ...values,
        departure_date: formatDateForAPI(values.departure_date),
        return_date: formatDateForAPI(values.return_date)
    };

    api().post('users/travel-orders', formData)
        .then(() => {
            emit('close');
            emit('refreshOrders');
            toast().success('Pedido salvo com sucesso!')
            handleReset()
        })
        .catch(error => {
            toast().error(getMessageError(error))
        })
})

function close() {
    handleReset()
}
</script>