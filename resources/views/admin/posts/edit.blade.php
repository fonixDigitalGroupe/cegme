@extends('admin.layout')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Modifier un article')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0;">Modifier un article</h1>
</div>

<form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <!-- Section 1: Informations principales -->
    <div class="card" style="margin-bottom: 0; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
        <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 2px solid #e2e8f0;">Informations principales</h2>
        
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Titre <span style="color: #dc2626;">*</span></label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="form-input" placeholder="Titre de l'article">
            @error('title') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 0;">
            <label class="form-label">Extrait</label>
            <textarea name="excerpt" rows="3" class="form-input" placeholder="Court résumé de l'article (optionnel, max 500 caractères)">{{ old('excerpt', $post->excerpt) }}</textarea>
            <p style="color: #64748b; font-size: 0.75rem; margin-top: 0.25rem;">Ce texte apparaîtra dans les aperçus et les listes d'articles.</p>
            @error('excerpt') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Section 2: Contenu -->
    <div class="card" style="margin-bottom: 0; border-radius: 0; border-top: none;">
        <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 2px solid #e2e8f0;">Contenu</h2>
        
        <div style="margin-bottom: 0;">
            <label class="form-label">Contenu de l'article <span style="color: #dc2626;">*</span></label>
            <div id="content-editor" style="min-height: 400px;"></div>
            <textarea name="content" id="content-hidden" style="display: none;" required>{{ old('content', $post->content) }}</textarea>
            <p style="color: #64748b; font-size: 0.75rem; margin-top: 0.25rem;">Utilisez l'éditeur pour formater votre texte et insérer des images.</p>
            @error('content') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Section 3: Médias -->
    <div class="card" style="margin-bottom: 0; border-radius: 0; border-top: none;">
        <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 2px solid #e2e8f0;">Médias</h2>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 0;">
            <div>
                <label class="form-label">Image de fond du titre</label>
                @if($post->header_image)
                    <div style="margin-bottom: 0.75rem; padding: 0.75rem; background-color: #f8fafc; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                        <p style="font-size: 0.75rem; color: #64748b; margin: 0 0 0.5rem 0;">Image actuelle :</p>
                        <img src="{{ asset('storage/' . $post->header_image) }}" alt="Image de fond actuelle" style="max-width: 100%; height: auto; max-height: 150px; border-radius: 0.375rem;" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div style="display: none; padding: 1rem; background-color: #fee2e2; color: #991b1b; border-radius: 0.375rem; font-size: 0.875rem;">Image non disponible</div>
                    </div>
                @endif
                <input type="file" name="header_image" accept="image/*" class="form-input">
                <p style="color: #64748b; font-size: 0.75rem; margin-top: 0.25rem;">Image affichée en arrière-plan du titre (format recommandé: 1920x600px)</p>
                @error('header_image') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="form-label">Image mise en avant</label>
                @if($post->featured_image)
                    <div style="margin-bottom: 0.75rem; padding: 0.75rem; background-color: #f8fafc; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                        <p style="font-size: 0.75rem; color: #64748b; margin: 0 0 0.5rem 0;">Image actuelle :</p>
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Image actuelle" style="max-width: 100%; height: auto; max-height: 150px; border-radius: 0.375rem;" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <div style="display: none; padding: 1rem; background-color: #fee2e2; color: #991b1b; border-radius: 0.375rem; font-size: 0.875rem;">Image non disponible</div>
                    </div>
                @endif
                <input type="file" name="featured_image" accept="image/*" class="form-input">
                <p style="color: #64748b; font-size: 0.75rem; margin-top: 0.25rem;">Image principale de l'article (format recommandé: 1200x630px)</p>
                @error('featured_image') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>
        </div>
    </div>

    <!-- Section 4: Classification et publication -->
    <div class="card" style="margin-bottom: 0; border-top-left-radius: 0; border-top-right-radius: 0; border-top: none;">
        <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 2px solid #e2e8f0;">Classification et publication</h2>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div>
                <label class="form-label">Statut <span style="color: #dc2626;">*</span></label>
                <select name="status" required class="form-input">
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="archived" {{ old('status', $post->status) === 'archived' ? 'selected' : '' }}>Archivé</option>
                </select>
                @error('status') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="form-label">Catégorie</label>
                <select name="category_id" class="form-input">
                    <option value="">Aucune catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div style="margin-bottom: 1.5rem;">
            <label class="form-label">Tags</label>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.75rem; padding: 1rem; background-color: #f8fafc; border-radius: 0.5rem; border: 1px solid #e2e8f0;">
                @if($tags->count() > 0)
                    @foreach($tags as $tag)
                        <label style="display: flex; align-items: center; cursor: pointer; padding: 0.5rem; border-radius: 0.375rem; transition: background-color 0.2s;" onmouseover="this.style.backgroundColor='#ffffff'" onmouseout="this.style.backgroundColor='transparent'">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }} style="margin-right: 0.5rem; cursor: pointer;">
                            <span style="font-size: 0.875rem;">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                @else
                    <p style="color: #64748b; font-size: 0.875rem; grid-column: 1 / -1;">Aucun tag disponible. Créez des tags depuis la section Tags.</p>
                @endif
            </div>
            @error('tags') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid #e2e8f0;">
            <a href="{{ route('admin.posts.index') }}" class="btn" style="background-color: #dc2626; color: rgb(255, 255, 255); border: none; text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">Annuler</a>
            <button type="submit" class="btn btn-primary">Mettre à jour l'article</button>
        </div>
    </div>
</form>

<!-- Quill.js - Éditeur WYSIWYG gratuit et open-source -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<style>
    .ql-editor {
        min-height: 400px;
    }
    .ql-editor img {
        max-width: 100% !important;
        height: auto !important;
        display: block !important;
        margin: 10px auto !important;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    /* Forcer l'affichage des images même si elles ne sont pas encore chargées */
    .ql-editor .ql-image {
        display: inline-block !important;
        max-width: 100% !important;
    }
    /* Style pour les images en cours de chargement */
    .ql-editor img[src] {
        min-height: 50px;
        background-color: #f3f4f6;
    }
</style>
<script>
    // Configuration personnalisée pour le format Image dans Quill
    var Image = Quill.import('formats/image');
    Image.sanitize = function(url) {
        return url;
    };
    Quill.register(Image, true);

    var quill = new Quill('#content-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image'],
                ['clean']
            ]
        },
        placeholder: 'Saisissez le contenu de votre article...'
    });

    // Gestion de l'upload d'images
    var toolbar = quill.getModule('toolbar');
    toolbar.addHandler('image', function() {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.click();

        input.onchange = function() {
            var file = input.files[0];
            if (file) {
                var formData = new FormData();
                formData.append('file', file);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route("admin.posts.upload-image") }}');
                
                var token = document.querySelector('meta[name="csrf-token"]');
                if (token) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', token.getAttribute('content'));
                }

                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            var response = JSON.parse(xhr.responseText);
                            console.log('Réponse serveur:', response);
                            
                            var imageUrl = response.location || response.url;
                            
                            if (!imageUrl) {
                                alert('Erreur: URL d\'image non reçue.\nRéponse complète: ' + JSON.stringify(response));
                                console.error('Réponse sans URL:', response);
                                return;
                            }
                            
                            console.log('URL de l\'image reçue:', imageUrl);
                            
                            // Vérifier que l'URL est valide
                            if (!imageUrl || imageUrl === 'undefined' || imageUrl === 'null') {
                                alert('Erreur: URL d\'image invalide: ' + imageUrl);
                                return;
                            }
                            
                            // Insérer directement l'image dans Quill
                            var range = quill.getSelection(true);
                            var index = range ? range.index : quill.getLength();
                            
                            try {
                                // Insérer l'image
                                quill.insertEmbed(index, 'image', imageUrl);
                                quill.setSelection(index + 1);
                                
                                // Vérifier que l'image s'est bien insérée
                                setTimeout(function() {
                                    var insertedImages = quill.root.querySelectorAll('img[src="' + imageUrl + '"]');
                                    if (insertedImages.length === 0) {
                                        console.warn('Image insérée mais non trouvée dans l\'éditeur');
                                        // Essayer de forcer l'affichage
                                        var allImages = quill.root.querySelectorAll('img');
                                        allImages.forEach(function(img) {
                                            if (!img.src || img.src === '') {
                                                img.src = imageUrl;
                                            }
                                        });
                                    } else {
                                        console.log('Image insérée et trouvée dans l\'éditeur');
                                    }
                                }, 200);
                                
                                console.log('Image insérée avec succès');
                            } catch (embedError) {
                                console.error('Erreur insertEmbed:', embedError);
                                alert('Erreur lors de l\'insertion de l\'image: ' + embedError.message + '\n\nURL: ' + imageUrl);
                            }
                            
                        } catch (e) {
                            alert('Erreur lors du traitement de la réponse: ' + e.message + '\n\nRéponse brute: ' + xhr.responseText);
                            console.error('Erreur complète:', e);
                            console.error('Réponse brute:', xhr.responseText);
                        }
                    } else {
                        var errorMsg = 'Erreur lors de l\'upload (code: ' + xhr.status + ')';
                        try {
                            var errorResponse = JSON.parse(xhr.responseText);
                            if (errorResponse.error) {
                                errorMsg += '\n' + errorResponse.error;
                            }
                            if (errorResponse.message) {
                                errorMsg += '\n' + errorResponse.message;
                            }
                        } catch (e) {
                            errorMsg += '\nRéponse: ' + xhr.responseText;
                        }
                        alert(errorMsg);
                        console.error('Erreur upload:', xhr.status, xhr.responseText);
                    }
                };

                xhr.onerror = function() {
                    alert('Erreur réseau lors de l\'upload de l\'image');
                };

                xhr.send(formData);
            }
        };
    });

    // Synchroniser le contenu avec le textarea caché avant la soumission
    var form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        var content = quill.root.innerHTML;
        document.querySelector('#content-hidden').value = content;
    });

    // Charger le contenu existant si présent et convertir les URLs d'images relatives en absolues
    var existingContent = document.querySelector('#content-hidden').value;
    if (existingContent) {
        // Convertir les URLs d'images relatives en absolues
        var tempDiv = document.createElement('div');
        tempDiv.innerHTML = existingContent;
        var images = tempDiv.querySelectorAll('img');
        images.forEach(function(img) {
            var src = img.getAttribute('src');
            if (src && !src.startsWith('http://') && !src.startsWith('https://')) {
                if (src.startsWith('/')) {
                    img.setAttribute('src', window.location.origin + src);
                } else {
                    img.setAttribute('src', window.location.origin + '/' + src);
                }
            }
        });
        quill.root.innerHTML = tempDiv.innerHTML;
        
        // Forcer le rechargement des images après un court délai
        setTimeout(function() {
            var images = quill.root.querySelectorAll('img');
            images.forEach(function(img) {
                if (!img.complete || img.naturalHeight === 0) {
                    var currentSrc = img.src;
                    img.src = '';
                    setTimeout(function() {
                        img.src = currentSrc;
                    }, 50);
                }
            });
        }, 200);
    }
</script>
@endsection
