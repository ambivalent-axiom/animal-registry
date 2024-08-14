import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, useForm, usePage } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';

export default function UpdateFarm({ auth, farm }: PageProps) {
    const { data, setData, put, processing, errors, reset } = useForm({
        farm_id: farm.id,
        name: farm.name,
        email: farm.email,
        website: farm.website,
    });
    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        put(route('farms.update'));
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
                                <TextInput
                                    id="farm_id"
                                    name="farm_id"
                                    value={data.farm_id}
                                    type="hidden"
                                />
                                <InputError className="mt-2" message={errors.farm_id}/>
                            </div>
                            <div className="ml-6 mr-6 mb-6">
                                <InputLabel htmlFor="name" value="Name"/>
                                <TextInput
                                    id="name"
                                    className="mt-1 block w-full"
                                    required
                                    isFocused
                                    onChange={(e) => setData('name', e.target.value)}
                                    type="text"
                                    value={data.name}
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
                                    onChange={(e) => setData('email', e.target.value)}
                                    value={data.email}
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
                                    type="url"
                                    onChange={(e) => setData('website', e.target.value)}
                                    value={data.website ?? ""}
                                    autoComplete="website"
                                />
                                <InputError className="mt-2" message={errors.website}/>
                            </div>
                            <div className="p-6">
                                <PrimaryButton className="ms-4" disabled={processing}>
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
