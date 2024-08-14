import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, useForm, usePage } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';

export default function CreateFarm({ auth }: PageProps) {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        website: '',
    });
    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('farms.store'));
    };

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Create Farm</h2>}
        >
            <Head title="Create Farm" />
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <form onSubmit={submit} className="mt-6 space-y-6">
                            <div className="ml-6 mr-6 mb-6">
                                <InputLabel htmlFor="name" value="Name"/>
                                <TextInput
                                    id="name"
                                    className="mt-1 block w-full"
                                    required
                                    isFocused
                                    maxLength="30"
                                    onChange={(e) => setData('name', e.target.value)}
                                    type="text"
                                    autoComplete="name"
                                />
                                <InputError className="mt-2" message={errors.name}/>
                            </div>
                            <div className="ml-6 mr-6 mb-6">
                                <InputLabel htmlFor="email" value="Email"/>
                                <TextInput
                                    id="email"
                                    className="mt-1 block w-full"
                                    required
                                    isFocused
                                    maxLength="30"
                                    onChange={(e) => setData('email', e.target.value)}
                                    type="email"
                                    autoComplete="email"
                                />
                                <InputError className="mt-2" message={errors.email}/>
                            </div>
                            <div className="ml-6 mr-6 mb-6">
                                <InputLabel htmlFor="website" value="Website"/>
                                <TextInput
                                    id="website"
                                    className="mt-1 block w-full"
                                    isFocused
                                    maxLength="100"
                                    type="url"
                                    onChange={(e) => setData('website', e.target.value)}
                                    autoComplete="website"
                                />
                                <InputError className="mt-2" message={errors.website}/>
                            </div>
                            <div className="p-6">
                                <PrimaryButton className="ms-4" disabled={processing}>
                                    Create
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
