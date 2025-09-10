<script setup lang="ts">
import AuthenticatedSessionController from '@/actions/App/Http/Controllers/Auth/AuthenticatedSessionController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import AuthSplitLayout from '@/layouts/auth/AuthSplitLayout.vue';
import { register } from '@/routes';
import { request } from '@/routes/password';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle, Mail, Lock } from 'lucide-vue-next';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <AuthSplitLayout title="Log in your Account">
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <Form
            v-bind="AuthenticatedSessionController.store.form()"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="grid gap-y-6"
        >
            <div class="grid gap-y-4">
                <div class="relative">
                    <Mail class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" />
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="Enter Email Id"
                        class="pl-10 rounded-full"
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <div class="relative">
                        <Lock class="absolute left-3 top-1/2 -translate-y-1/2 h-5 w-5 text-gray-400" />
                        <Input
                            id="password"
                            type="password"
                            name="password"
                            required
                            :tabindex="2"
                            autocomplete="current-password"
                            placeholder="Enter Password"
                            class="pl-10 rounded-full"
                        />
                        <InputError :message="errors.password" />
                    </div>
                    <div class="flex items-center justify-end">
                        <TextLink v-if="canResetPassword" :href="request()" class="text-sm" :tabindex="5"> Forgot Password? </TextLink>
                    </div>
                </div>

                <Button type="submit" class="w-full rounded-full bg-[#FFD633] hover:bg-[#FFD633]/90 text-black" :tabindex="4" :disabled="processing">
                    <LoaderCircle v-if="processing" class="h-4 w-4 animate-spin" />
                    Login
                </Button>
            </div>

            <div class="text-center text-sm text-muted-foreground">
                Don't have an account?
                <TextLink :href="register()" :tabindex="5" class="font-semibold">SIGN UP</TextLink>
            </div>
        </Form>
    </AuthSplitLayout>
</template>
