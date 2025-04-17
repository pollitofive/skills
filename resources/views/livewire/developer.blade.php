<div>
    <div id="form-developer">
        <h1>Developers</h1>
        <form wire:submit="submitForm" novalidate>
            @include('message-confirmation')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title mb-0">
                                New developer
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-lg-6">
                                    <div>
                                        <label for="firstname" class="form-label">Firstname</label>
                                        <input type="text" wire:model="firstname" class="form-control" id="firstname" placeholder="Firstname" tabindex="1" maxlength="50">
                                        @error('firstname') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="mt-3">
                                        <label for="nid" class="form-label">Nid</label>
                                        <input type="text"  wire:model="nid" class="form-control" id="nid" placeholder="Nid" tabindex="3" maxlength="8">
                                        @error('nid') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mt-3">
                                        <label for="email" class="form-label">Email</label>
                                        <div class="form-icon">
                                            <input type="email" wire:model="email" class="form-control form-control-icon" id="iconInput" placeholder="example@gmail.com" tabindex="4" maxlength="50">
                                            <i class="ri-mail-unread-line"></i>
                                        </div>
                                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="mt-3">
                                        <label for="birthday" class="form-label">Birthday</label>
                                        <input type="text" wire:model="birthday" class="form-control flatpickr-input" id="birthday" data-provider="flatpickr" data-date-format="d M, Y" tabindex="5" placeholder="Format 2000-12-31">
                                        @error('birthday') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

{{--                                <div class="col-lg-6">--}}
{{--                                    <div>--}}
{{--                                        <label for="lastname" class="form-label">Lastname</label>--}}
{{--                                        <input type="text" wire:model="lastname" class="form-control" id="lastname" placeholder="Lastname" tabindex="2">--}}
{{--                                        @error('lastname') <span class="invalid-feedback">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}
{{--                                    <div class="mt-3" >--}}
{{--                                        <label for="skills" class="form-label">Skills</label>--}}
{{--                                        <select required multiple="multiple" wire:model="skills" id="skills">--}}
{{--                                            @foreach($list_skills as $skill)--}}
{{--                                                <option value="{{ $skill->id }}">{{ $skill->description }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @error('skills') <span class="invalid-feedback">{{ $message }}</span> @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                --}}
                                <div class="col-lg-6">
                                    <div>
                                        <label for="lastname" class="form-label">Lastname</label>
                                        <input
                                            type="text"
                                            wire:model="lastname"
                                            class="form-control"
                                            id="lastname"
                                            placeholder="Lastname"
                                            tabindex="2"
                                        >
                                        @error('lastname')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mt-3">
                                        <label class="form-label">Skills</label>
                                        <div
                                            x-data="{
                                                options: @js($list_skills),
                                                search: '',
                                                selected: @entangle('skills')
                                            }"
                                            class="space-y-2"
                                        >
                                            <input
                                                x-model="search"
                                                type="search"
                                                placeholder="🔍 Buscar..."
                                                class="border rounded px-2 py-1 w-full"
                                            />

                                            <div class="overflow-y-auto max-h-64 border rounded p-2">
                                                <template
                                                    x-for="skill in options.filter(s => s.description.toLowerCase().includes(search.toLowerCase()))"
                                                    :key="skill.id"
                                                >
                                                    <label class="flex items-center space-x-2 mb-2 py-1 px-2">
                                                        <input
                                                            type="checkbox"
                                                            :value="skill.id"
                                                            x-model="selected"
                                                        />
                                                        <span x-text="skill.description"></span>
                                                    </label>
                                                </template>
                                                <div
                                                    x-show="! options.filter(s => s.description.toLowerCase().includes(search.toLowerCase())).length"
                                                    class="text-center text-sm text-gray-500"
                                                >
                                                    Nada para mostrar
                                                </div>
                                            </div>
                                        </div>
                                        @error('skills')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                            <div class="row mt-3 justify-content-end">
                                <div class="col-sm-1">
                                    <button wire:submit="submitForm" class="btn btn-outline-success" type="submit" id="button-addon2">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr("#birthday", {
            dateFormat: "Y-m-d",
            allowInput: true
        });
    </script>
    <script>
        /*
        function createMultiJsElement()
        {
            var multiSelectBasic = document.getElementById("skills");

            if (multiSelectBasic) {
                multi(multiSelectBasic, {
                    non_selected_header: "Not selected",
                    selected_header: "Selected"
                });
            }
        }
        document.addEventListener("DOMContentLoaded", () => {
            createMultiJsElement();
        });

        window.addEventListener('contentChanged', e => {
            // createMultiJsElement();
        });

        document.addEventListener("livewire:init", () => {
            Livewire.hook('message.processed', (message, component) => {
                createMultiJsElement();
            });
        });
        */

    </script>

    <script>
        window.addEventListener('scroll-to-top', (ev) => {
            ev.stopPropagation();
            const el = window.document.getElementById("layout-wrapper");
            el.scrollIntoView({
                behavior: 'smooth',
            });
        }, false);

        window.addEventListener('scroll-to-list', (ev) => {
            ev.stopPropagation();
            const el = window.document.getElementById("list-developers");
            el.scrollIntoView({
                behavior: 'smooth',
            });
        }, false);

    </script>

</div>
