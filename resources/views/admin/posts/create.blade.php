@extends('admin.layout')

@section('title', 'Créer un article')

@section('content')
<div style="margin-bottom: 1.5rem;">
    <h1 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0;">Créer un article</h1>
</div>

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <!-- Section 1: Informations principales -->
    <div class="card" style="margin-bottom: 0; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
        <h2 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 1.25rem 0; padding-bottom: 0.75rem; border-bottom: 2px solid #e2e8f0;">Informations principales</h2>
        
        <div style="margin-bottom: 1.25rem;">
            <label class="form-label">Titre <span style="color: #dc2626;">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required class="form-input" placeholder="Titre de l'article">
            @error('title') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
        </div>
        
        <div style="margin-bottom: 0;">
            <label class="form-label">Extrait</label>
            <textarea name="excerpt" rows="3" class="form-input" placeholder="Court résumé de l'article (optionnel, max 500 caractères)">{{ old('excerpt') }}</textarea>
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
            <textarea name="content" id="content-hidden" style="display: none;" required>{{ old('content') }}</textarea>
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
                <input type="file" name="header_image" accept="image/*" class="form-input">
                <p style="color: #64748b; font-size: 0.75rem; margin-top: 0.25rem;">Image affichée en arrière-plan du titre (format recommandé: 1920x600px)</p>
                @error('header_image') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="form-label">Image mise en avant</label>
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
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archivé</option>
                </select>
                @error('status') <p style="color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label class="form-label">Catégorie</label>
                <select name="category_id" class="form-input">
                    <option value="">Aucune catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} style="margin-right: 0.5rem; cursor: pointer;">
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
            <button type="submit" class="btn btn-primary">Créer l'article</button>
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
    /* Styles pour l'alignement des images - Toujours centrées par défaut */
    .ql-editor img {
        cursor: move;
        transition: opacity 0.2s;
        user-select: none;
        display: block !important;
        margin-left: auto !important;
        margin-right: auto !important;
        margin-top: 1em !important;
        margin-bottom: 1em !important;
    }
    .ql-editor img:hover {
        opacity: 0.9;
    }
    .ql-editor img.dragging {
        opacity: 0.5;
        cursor: grabbing;
    }
    .ql-editor img[style*="float: left"],
    .ql-editor img[style*="margin-left: 0"] {
        float: left;
        margin-right: 1em;
        margin-left: 0;
    }
    .ql-editor img[style*="float: right"],
    .ql-editor img[style*="margin-right: 0"] {
        float: right;
        margin-left: 1em;
        margin-right: 0;
    }
    .ql-editor img[style*="display: block"][style*="margin-left: auto"],
    .ql-editor img[style*="margin: 0 auto"],
    .ql-editor img.ql-align-center {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    /* Menu contextuel pour l'alignement des images */
    .image-align-menu {
        position: absolute;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 10000;
        display: none;
        gap: 4px;
        flex-direction: column;
    }
    .image-align-menu.show {
        display: flex;
    }
    .image-align-menu .menu-row {
        display: flex;
        gap: 4px;
    }
    .image-align-menu button {
        padding: 8px 12px;
        border: 1px solid #d1d5db;
        background: white;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .image-align-menu button:hover {
        background: #f3f4f6;
        border-color: #10b981;
    }
    .image-align-menu button.active {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }
    .image-align-menu button.delete {
        background: #dc2626;
        color: white;
        border-color: #dc2626;
        margin-top: 4px;
    }
    .image-align-menu button.delete:hover {
        background: #b91c1c;
        border-color: #b91c1c;
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
    
    // Système de taille standard pour les images
    var standardImageSize = null;
    var imageCount = 0;
    
    // Fonction pour appliquer la taille standard à une image
    function applyStandardSize(img) {
        if (standardImageSize && img) {
            img.style.width = standardImageSize.width;
            img.style.height = standardImageSize.height;
            img.style.maxWidth = standardImageSize.width;
            img.style.maxHeight = standardImageSize.height;
        }
    }
    
    // Fonction pour définir la taille standard à partir d'une image
    function setStandardSizeFromImage(img) {
        if (img && img.complete && img.naturalWidth > 0) {
            // Calculer la taille en préservant le ratio, avec une largeur max de 800px
            var maxWidth = 800;
            var ratio = img.naturalWidth / img.naturalHeight;
            var width = Math.min(img.naturalWidth, maxWidth);
            var height = width / ratio;
            
            standardImageSize = {
                width: width + 'px',
                height: height + 'px'
            };
            
            console.log('Taille standard définie:', standardImageSize);
            
            // Appliquer cette taille à toutes les images existantes
            setTimeout(function() {
                quill.root.querySelectorAll('img').forEach(function(existingImg) {
                    if (existingImg !== img) {
                        applyStandardSize(existingImg);
                    }
                });
            }, 100);
        }
    }

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
                                
                                // Compter les images
                                imageCount++;
                                
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
                                        
                                        var insertedImg = insertedImages[0];
                                        
                                        // Centrer automatiquement l'image
                                        insertedImg.style.display = 'block';
                                        insertedImg.style.marginLeft = 'auto';
                                        insertedImg.style.marginRight = 'auto';
                                        insertedImg.style.marginTop = '1em';
                                        insertedImg.style.marginBottom = '1em';
                                        insertedImg.style.float = '';
                                        
                                        // Synchroniser le contenu après insertion de l'image
                                        setTimeout(function() {
                                            syncContent();
                                        }, 100);
                                        
                                        // Si c'est la deuxième image, définir la taille standard
                                        if (imageCount === 2) {
                                            insertedImg.onload = function() {
                                                setStandardSizeFromImage(insertedImg);
                                                // Recentrer après chargement
                                                insertedImg.style.display = 'block';
                                                insertedImg.style.marginLeft = 'auto';
                                                insertedImg.style.marginRight = 'auto';
                                                syncContent();
                                            };
                                            // Si l'image est déjà chargée
                                            if (insertedImg.complete && insertedImg.naturalWidth > 0) {
                                                setStandardSizeFromImage(insertedImg);
                                                syncContent();
                                            }
                                        } else if (imageCount > 2 && standardImageSize) {
                                            // Appliquer la taille standard aux images suivantes
                                            applyStandardSize(insertedImg);
                                            syncContent();
                                        }
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

    // Synchroniser le contenu avec le textarea caché en temps réel
    function syncContent() {
        var content = quill.root.innerHTML;
        document.querySelector('#content-hidden').value = content;
    }
    
    // Écouter tous les changements dans Quill pour synchroniser automatiquement
    quill.on('text-change', function() {
        syncContent();
    });
    
    // Synchroniser aussi avant la soumission du formulaire
    var form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        syncContent();
    });

    // Charger le contenu existant si présent
    var existingContent = document.querySelector('#content-hidden').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
        
        // Centrer toutes les images existantes et définir la taille standard
        setTimeout(function() {
            var images = quill.root.querySelectorAll('img');
            images.forEach(function(img) {
                img.style.display = 'block';
                img.style.marginLeft = 'auto';
                img.style.marginRight = 'auto';
                img.style.marginTop = '1em';
                img.style.marginBottom = '1em';
                img.style.float = '';
                img.classList.remove('ql-align-left', 'ql-align-right');
                img.classList.add('ql-align-center');
            });
            
            imageCount = images.length;
            
            // Si on a au moins 2 images, définir la taille standard à partir de la deuxième
            if (images.length >= 2) {
                var secondImage = images[1];
                secondImage.onload = function() {
                    setStandardSizeFromImage(secondImage);
                };
                // Si l'image est déjà chargée
                if (secondImage.complete && secondImage.naturalWidth > 0) {
                    setStandardSizeFromImage(secondImage);
                } else {
                    // Attendre que l'image se charge
                    secondImage.addEventListener('load', function() {
                        setStandardSizeFromImage(secondImage);
                    });
                }
            }
        }, 300);
    }
    
    // Système d'alignement des images
    var imageAlignMenu = null;
    var selectedImageForAlign = null;
    
    // Créer le menu d'alignement
    function createAlignMenu() {
        if (imageAlignMenu) return imageAlignMenu;
        
        var menu = document.createElement('div');
        menu.className = 'image-align-menu';
        menu.innerHTML = `
            <div class="menu-row">
                <button data-align="left" title="Aligner à gauche">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="15" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <button data-align="center" title="Centrer">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="6" y1="12" x2="18" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
                <button data-align="right" title="Aligner à droite">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="9" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>
            <button class="delete" data-action="delete" title="Supprimer l'image">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="m19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
                Supprimer
            </button>
        `;
        document.body.appendChild(menu);
        
        // Ajouter les gestionnaires d'événements
        menu.querySelectorAll('button').forEach(function(btn) {
            btn.addEventListener('click', function() {
                if (this.dataset.action === 'delete') {
                    deleteImage(selectedImageForAlign);
                    hideAlignMenu();
                } else {
                    var align = this.dataset.align;
                    alignImage(selectedImageForAlign, align);
                    hideAlignMenu();
                }
            });
        });
        
        return menu;
    }
    
    // Fonction pour supprimer une image
    function deleteImage(img) {
        if (!img) return;
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
            // Supprimer l'image du DOM
            if (img.parentNode) {
                img.parentNode.removeChild(img);
            } else {
                img.remove();
            }
            
            // Mettre à jour le contenu Quill
            syncContent();
        }
    }
    
    // Afficher le menu d'alignement
    function showAlignMenu(img, x, y) {
        selectedImageForAlign = img;
        if (!imageAlignMenu) {
            imageAlignMenu = createAlignMenu();
        }
        
        // Positionner le menu
        imageAlignMenu.style.left = x + 'px';
        imageAlignMenu.style.top = (y - 50) + 'px';
        imageAlignMenu.classList.add('show');
        
        // Mettre à jour l'état actif des boutons
        var currentAlign = getImageAlign(img);
        imageAlignMenu.querySelectorAll('button').forEach(function(btn) {
            if (btn.dataset.align === currentAlign) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }
    
    // Cacher le menu d'alignement
    function hideAlignMenu() {
        if (imageAlignMenu) {
            imageAlignMenu.classList.remove('show');
            selectedImageForAlign = null;
        }
    }
    
    // Obtenir l'alignement actuel d'une image
    function getImageAlign(img) {
        var style = img.style.cssText || '';
        if (style.includes('float: left') || img.style.float === 'left') {
            return 'left';
        } else if (style.includes('float: right') || img.style.float === 'right') {
            return 'right';
        } else if (style.includes('margin-left: auto') || style.includes('margin: 0 auto') || img.classList.contains('ql-align-center')) {
            return 'center';
        }
        return 'center'; // Par défaut centré
    }
    
    // Aligner une image - Toujours centrer
    function alignImage(img, align) {
        if (!img) return;
        
        // Toujours centrer l'image, peu importe le choix
        img.style.float = '';
        img.style.marginLeft = 'auto';
        img.style.marginRight = 'auto';
        img.style.display = 'block';
        img.style.marginTop = '1em';
        img.style.marginBottom = '1em';
        img.classList.remove('ql-align-center', 'ql-align-left', 'ql-align-right');
        img.classList.add('ql-align-center');
        
        // Mettre à jour le contenu Quill
        updateQuillContent();
    }
    
    // Fonction pour centrer automatiquement toutes les images
    function centerAllImages() {
        quill.root.querySelectorAll('img').forEach(function(img) {
            img.style.float = '';
            img.style.marginLeft = 'auto';
            img.style.marginRight = 'auto';
            img.style.display = 'block';
            img.style.marginTop = '1em';
            img.style.marginBottom = '1em';
            img.classList.remove('ql-align-left', 'ql-align-right');
            img.classList.add('ql-align-center');
        });
        updateQuillContent();
    }
    
    // Mettre à jour le contenu Quill
    function updateQuillContent() {
        syncContent();
    }
    
    // Système de déplacement d'images avec la souris
    var isDraggingImage = false;
    var draggedImage = null;
    var dragStartX = 0;
    var dragStartY = 0;
    var imageStartX = 0;
    var imageStartY = 0;
    var placeholder = null;
    
    // Créer un placeholder pour indiquer où l'image sera déposée
    function createPlaceholder() {
        if (placeholder) return placeholder;
        placeholder = document.createElement('div');
        placeholder.style.border = '2px dashed #10b981';
        placeholder.style.height = '50px';
        placeholder.style.margin = '10px 0';
        placeholder.style.borderRadius = '4px';
        placeholder.style.backgroundColor = '#f0fdf4';
        placeholder.style.display = 'none';
        return placeholder;
    }
    
    // Écouter les clics sur les images pour commencer le déplacement
    quill.root.addEventListener('mousedown', function(e) {
        if (e.target.tagName === 'IMG' && e.target.closest('.ql-editor')) {
            // Si on clique sur le menu d'alignement, ne pas démarrer le drag
            if (e.target.closest('.image-align-menu')) {
                return;
            }
            
            draggedImage = e.target;
            isDraggingImage = true;
            draggedImage.classList.add('dragging');
            
            var rect = draggedImage.getBoundingClientRect();
            dragStartX = e.clientX;
            dragStartY = e.clientY;
            imageStartX = rect.left;
            imageStartY = rect.top;
            
            // Créer le placeholder
            placeholder = createPlaceholder();
            placeholder.style.width = draggedImage.offsetWidth + 'px';
            placeholder.style.height = draggedImage.offsetHeight + 'px';
            
            e.preventDefault();
            e.stopPropagation();
        }
    });
    
    // Gérer le mouvement de la souris pendant le drag
    document.addEventListener('mousemove', function(e) {
        if (!isDraggingImage || !draggedImage) return;
        
        var deltaX = e.clientX - dragStartX;
        var deltaY = e.clientY - dragStartY;
        
        // Déplacer l'image visuellement
        draggedImage.style.position = 'fixed';
        draggedImage.style.left = (imageStartX + deltaX) + 'px';
        draggedImage.style.top = (imageStartY + deltaY) + 'px';
        draggedImage.style.zIndex = '10000';
        draggedImage.style.pointerEvents = 'none';
        
        // Trouver la position d'insertion dans l'éditeur
        var editorRect = quill.root.getBoundingClientRect();
        var x = e.clientX - editorRect.left;
        var y = e.clientY - editorRect.top;
        
        // Trouver le nœud le plus proche dans l'éditeur
        var range = document.caretRangeFromPoint ? document.caretRangeFromPoint(e.clientX, e.clientY) : null;
        if (range) {
            var node = range.startContainer;
            
            // Trouver un élément parent approprié pour insérer le placeholder
            while (node && node !== quill.root) {
                if (node.nodeType === Node.ELEMENT_NODE) {
                    var element = node;
                    if (element.tagName !== 'IMG' && element !== draggedImage) {
                        // Insérer le placeholder avant cet élément
                        if (!placeholder.parentNode) {
                            element.parentNode.insertBefore(placeholder, element);
                        } else if (placeholder.nextSibling !== element) {
                            element.parentNode.insertBefore(placeholder, element);
                        }
                        placeholder.style.display = 'block';
                        break;
                    }
                }
                node = node.parentNode;
            }
        }
    });
    
    // Gérer la fin du drag
    document.addEventListener('mouseup', function(e) {
        if (!isDraggingImage || !draggedImage) return;
        
        isDraggingImage = false;
        draggedImage.classList.remove('dragging');
        
        // Restaurer le style de l'image
        draggedImage.style.position = '';
        draggedImage.style.left = '';
        draggedImage.style.top = '';
        draggedImage.style.zIndex = '';
        draggedImage.style.pointerEvents = '';
        
        // Si un placeholder existe, déplacer l'image à sa position
        if (placeholder && placeholder.parentNode) {
            placeholder.parentNode.insertBefore(draggedImage, placeholder);
            placeholder.parentNode.removeChild(placeholder);
            placeholder.style.display = 'none';
        }
        
        // Recentrer l'image après déplacement
        if (draggedImage) {
            draggedImage.style.float = '';
            draggedImage.style.marginLeft = 'auto';
            draggedImage.style.marginRight = 'auto';
            draggedImage.style.display = 'block';
            draggedImage.style.marginTop = '1em';
            draggedImage.style.marginBottom = '1em';
        }
        
        // Mettre à jour le contenu Quill
        updateQuillContent();
        
        draggedImage = null;
    });
    
    // Écouter les clics simples sur les images pour afficher le menu d'alignement
    var clickTimer = null;
    quill.root.addEventListener('click', function(e) {
        if (e.target.tagName === 'IMG' && e.target.closest('.ql-editor')) {
            // Si on vient de faire un drag, ne pas afficher le menu
            if (clickTimer) {
                clearTimeout(clickTimer);
            }
            
            clickTimer = setTimeout(function() {
                if (!isDraggingImage) {
                    var rect = e.target.getBoundingClientRect();
                    var x = rect.left + (rect.width / 2);
                    var y = rect.top;
                    showAlignMenu(e.target, x, y);
                }
            }, 200);
        } else if (!e.target.closest('.image-align-menu')) {
            hideAlignMenu();
        }
    });
    
    // Fermer le menu en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.image-align-menu') && !e.target.closest('.ql-editor img')) {
            hideAlignMenu();
        }
    });
</script>
@endsection

