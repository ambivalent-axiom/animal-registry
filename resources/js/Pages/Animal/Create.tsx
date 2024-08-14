import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, useForm, usePage } from '@inertiajs/react';
import { FormEventHandler } from 'react';
import { Head } from '@inertiajs/react';
import { PageProps } from '@/types';

export default function CreateAnimal({ auth, farmId }: PageProps) {
    const { data, setData, post, processing, errors, reset } = useForm({
        farm_id: farmId,
        animal_number: '',
        type_name: '',
        years: '',
    });
    const submit: FormEventHandler = (e) => {
        e.preventDefault();
        post(route('animals.store'));
    };
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Add animal to farm</h2>}
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
                                <InputLabel htmlFor="animal_number" value="Number"/>
                                <TextInput
                                    id="animal_number"
                                    className="mt-1 block w-full"
                                    required
                                    isFocused
                                    onChange={(e) => setData('animal_number', e.target.value)}
                                    type="number"
                                    autoComplete="animal_number"
                                />
                                <InputError className="mt-2" message={errors.animal_number}/>
                            </div>
                            <div className="ml-6 mr-6 mb-6">
                                <InputLabel htmlFor="type_name" value="Type"/>
                                <TextInput
                                    id="type_name"
                                    className="mt-1 block w-full"
                                    required
                                    isFocused
                                    onChange={(e) => setData('type_name', e.target.value)}
                                    type="text"
                                    autoComplete="type_name"
                                />
                                <InputError className="mt-2" message={errors.type_name}/>
                            </div>
                            <div className="ml-6 mr-6 mb-6">
                                <InputLabel htmlFor="years" value="Years"/>
                                <TextInput
                                    id="years"
                                    className="mt-1 block w-full"
                                    isFocused
                                    type="number"
                                    onChange={(e) => setData('years', e.target.value)}
                                    autoComplete="years"
                                />
                                <InputError className="mt-2" message={errors.years}/>
                            </div>
                            <div className="p-6">
                                <PrimaryButton className="ms-4" disabled={processing}>
                                    Add to farm
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
