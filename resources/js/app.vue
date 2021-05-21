<template>
    <div class="flex h-screen bg-gray-200 font-roboto">

        <sidebar />

        <div class="flex-1 flex flex-col overflow-hidden">

            <app-header />

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
                <div class="container mx-auto px-6 py-8">

                    <div class="overflow-x-auto">
                        <div class="min-w-screen min-h-screen bg-gray-100 flex justify-center bg-gray-100 font-sans overflow-hidden">
                            <div class="w-full m-5">
                                <div class="bg-white shadow-md rounded my-6 p-5">
                                    <button @click="showModal = true" type="button" class="focus:outline-none text-white text-sm py-2.5 px-5 rounded-md bg-blue-500 hover:bg-blue-600 hover:shadow-lg flex items-center float-right mb-5">
                                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        Create Account
                                    </button>

                                    <not-found v-if="accounts.length === 0"/>

                                    <table v-if="accounts.length > 0" class="min-w-max w-full table-auto">
                                        <thead>
                                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                            <th class="py-3 px-6 text-left">Account Name</th>
                                            <th class="py-3 px-6 text-left">Bank</th>
                                            <th class="py-3 px-6 text-center">Account Number</th>
                                            <th class="py-3 px-6 text-center">Branch</th>
                                            <th class="py-3 px-6 text-center">Account Type</th>
                                            <th class="py-3 px-6 text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="text-gray-600 text-sm font-light">
                                        <tr v-for="(item, index) in accounts" :key="index" class="border-b border-gray-200 hover:bg-gray-100">
                                            <td class="py-3 px-6 text-left whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <span class="font-medium">{{ item.account_name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                {{ item.bank && item.bank.short_name || null }}
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                {{ item.account_no }}
                                            </td>
                                            <td class="py-3 px-6 text-left">
                                                {{ item.branch }}
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <span :class="getTypeWithClass(item.account_type).class">
                                                    {{ getTypeWithClass(item.account_type).name }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-6 text-center">
                                                <div class="flex item-center justify-center">
                                                    <button v-if="isAdmin" type="button"
                                                            class="focus:outline-none text-green-600 text-xs py-2.5 px-5 rounded-md hover:bg-blue-100"
                                                            @click="updateAccount(item)"
                                                    >Edit</button>
                                                    <button v-if="isAdmin" type="button"
                                                            class="focus:outline-none text-red-600 text-xs py-2.5 px-5 rounded-md hover:bg-blue-100"
                                                            @click="deleteAccount(item.id)"
                                                    >Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>

        <!-- // New loan Application Modal //  -->
        <div class="fixed inset-0 w-full h-full z-20 bg-black bg-opacity-50 duration-300 overflow-y-auto" v-if="showModal">
            <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3 mx-2 sm:mx-auto mt-10 mb-24 opacity-100">
                <div class="relative bg-white shadow-lg rounded-lg text-gray-900 z-20">
                    <header class="flex flex-col justify-center items-center p-3 text-blue-600">
                        <h2 class="font-semibold text-2xl">Create Account</h2>
                    </header>
                    <main class="p-3">
                        <form @submit.prevent>
                            <div class="mb-6">
                                <label for="account_name" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Account Name</label>
                                <input v-model="form.account_name" type="text" name="account_name" id="account_name" placeholder="Account Name" required class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                            </div>
                            <div class="mb-6">
                                <label for="bank" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Bank</label>
                                <select v-model="form.financial_organization_id" required name="bank" id="bank" class="w-full border border-1 border-gray-200 py-3 rounded">
                                    <option value="1">Saving</option>
                                    <option value="2">Current</option>
                                    <option value="3">Joint</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="account_no" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Account Number</label>
                                <input v-model="form.account_no" type="text" name="account_no" id="account_no" placeholder="Account Number" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                            </div>
                            <div class="mb-6">
                                <label for="branch" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Branch</label>
                                <input v-model="form.branch" type="text" name="branch" id="branch" placeholder="Branch" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                            </div>
                            <div class="mb-6">
                                <label for="account_type" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Account Type</label>
                                <select v-model="form.account_type" name="account_type" id="account_type" class="w-full border border-1 border-gray-200 py-3 rounded">
                                    <option value="1">Saving</option>
                                    <option value="2">Current</option>
                                    <option value="3">Joint</option>
                                </select>
                            </div>
                            <div class="mb-6">
                                <label for="swift_code" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Swift Code</label>
                                <input v-model="form.swift_code" type="number" name="swift_code" id="swift_code" placeholder="Swift Code" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                            </div>
                            <div class="mb-6">
                                <label for="route_no" class="block mb-2 text-sm text-gray-600 dark:text-gray-400">Route Number</label>
                                <input v-model="form.route_no" type="number" name="route_no" id="route_no" placeholder="Route Number" class="w-full px-3 py-2 placeholder-gray-300 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-indigo-100 focus:border-indigo-300 dark:bg-gray-700 dark:text-white dark:placeholder-gray-500 dark:border-gray-600 dark:focus:ring-gray-900 dark:focus:border-gray-500" />
                            </div>
                        </form>
                    </main>
                    <footer class="flex justify-center bg-transparent">
                        <button class="bg-red-600 font-semibold text-white py-3 w-full rounded-bl-md hover:bg-blue-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300" @click="showModal = false">
                            Cancel
                        </button>
                        <button class="bg-blue-600 font-semibold text-white py-3 w-full rounded-br-md hover:bg-blue-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300" @click="createAccount()">
                            Save
                        </button>
                    </footer>
                </div>
            </div>
        </div>

        <!-- // Showing EMI Details Modal // -->
        <div class="fixed inset-0 w-full h-full z-20 bg-black bg-opacity-50 duration-300 overflow-y-auto" v-if="showDetailsModal">
            <div class="relative sm:w-3/5 md:w-3/5 lg:w-3/5 mx-2 sm:mx-auto mt-10 mb-24 opacity-100">
                <div class="relative bg-white shadow-lg rounded-lg text-gray-900 z-20">
                    <header class="flex flex-col justify-center items-center p-3 text-blue-600">
                        <h2 class="font-semibold text-2xl">EMI Details</h2>
                    </header>
                    <main class="p-3">

                        <div class="grid grid-cols-3 gap-4 m-4">
                            <div><strong>Amount:</strong> {{ emiDetails.amount }}</div>
                            <div><strong>Duration:</strong> {{ emiDetails.duration }}</div>
                            <div><strong>Interest rate:</strong> {{ emiDetails.interest_rate }}</div>
                            <div><strong>EMI:</strong> {{ emiDetails.emi }}</div>
                            <div><strong>Monthly interest:</strong> {{ emiDetails.monthly_interest }}</div>
                            <div><strong>Monthly principal amount:</strong> {{ emiDetails.monthly_principal_amount }}</div>
                            <div><strong>Total interest:</strong> {{ emiDetails.total_interest }}</div>
                            <div><strong>Status:</strong>
                                <span :class="getStatusClass(emiDetails.status)">
                                    {{ emiDetails.status }}
                                </span>
                            </div>
                        </div>

                        <table v-if="emiDetails.emi_details.length > 0" class="min-w-max w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Serial</th>
                                <th class="py-3 px-6 text-left">Title</th>
                                <th class="py-3 px-6 text-center">Total Amount</th>
                                <th class="py-3 px-6 text-center">Payment Date</th>
                                <th class="py-3 px-6 text-center">Payment End Date</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 text-sm font-light">
                            <tr v-for="(item, index) in emiDetails.emi_details" :key="index" class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">{{ item.serial }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ item.title }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ item.total_amount }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ getDate(item.payment_date, 'll') }}
                                </td>
                                <td class="py-3 px-6 text-left">
                                    {{ getDate(item.payment_end_date, 'll') }}
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </main>
                    <footer class="flex justify-center bg-transparent">
                        <button class="bg-red-600 font-semibold text-white py-3 w-full rounded-bl-md hover:bg-blue-700 focus:outline-none focus:ring shadow-lg hover:shadow-none transition-all duration-300" @click="showDetailsModal = false">
                            Close
                        </button>
                    </footer>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import Sidebar from './layouts/sidebar.vue';
    import AppHeader from './layouts/header.vue';
    import NotFound from './components/not-found.vue';
    import Helpers from "./helpers";
    export default {
        name: "App",
        components: {
            Sidebar,
            AppHeader,
            NotFound
        },
        props: ['isAdmin'],
        data() {
            return {
                accounts: [],
                showModal: false,
                showDetailsModal: false,
                form: {
                    account_name: null,
                    financial_organization_id: null,
                    account_no: null,
                    account_type: null,
                    branch: null,
                    swift_code: null,
                    route_code: null,
                },
                emiDetails: {}
            }
        },
        mounted() {
            this.getAllAccounts();
        },
        methods: {
            getTypeWithClass(type) {
                if (type === 1) {
                    return {
                        class: "bg-green-200 text-green-600 py-1 px-3 rounded-full text-xs",
                        name: 'Savings Account'
                    };
                }
                if (type === 2) {
                    return {
                        class: "bg-red-200 text-red-600 py-1 px-3 rounded-full text-xs",
                        name: 'Current Account'
                    }
                }
                return {
                    class: "bg-purple-200 text-purple-600 py-1 px-3 rounded-full text-xs",
                    name: 'Joint Account'
                }
            },
            getAllAccounts() {
                Helpers.api.get('/api/accounts').then(res => {
                    if (res.status === 200) {
                        Helpers.notify('top-end', 'success', 'Successfully fetched!');
                        this.accounts = res.data;
                    }
                }).catch(e => {
                    console.log(e)
                })
            },
            createAccount() {
                if (!this.form.account_name || !this.form.financial_organization_id) {
                    Helpers.notify('top-end', 'error', 'Required fields are missing!');
                    return false;
                }
                if (this.form.account_name && this.form.financial_organization_id) {
                    Helpers.api.post('/api/accounts', this.form).then(res => {
                        if (res.status === 201) {
                            Helpers.notify('top-end', 'success', 'Successfully created!');
                            this.showModal = false;
                            window.location.reload();
                        }
                    }).catch(e => {
                        console.log(e)
                    })
                } else {
                    Helpers.notify('top-end', 'error', 'All fields are required!');
                    return false;
                }
            },
            updateAccount(account) {
                if (account) {
                    this.form = account;
                    this.showModal = true;
                    // Helpers.api.put(`/api/accounts/${account.id}`, this.form).then(res => {
                    //     if (res.status === 200) {
                    //         Helpers.notify('top-end', 'success', 'Account updated!');
                    //         window.location.reload();
                    //     }
                    // }).catch(e => {
                    //     console.log(e)
                    // })
                }
            },
            deleteAccount(id) {
                Helpers.api.delete(`/api/accounts/${id}`).then(res => {
                    if (res.status === 200) {
                        Helpers.notify('top-end', 'success', 'Account deleted!');
                        window.location.reload();
                    }
                }).catch(e => {
                    console.log(e)
                })
            }
        }
    };
</script>
