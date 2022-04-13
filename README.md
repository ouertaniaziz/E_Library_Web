## PHP version php8.0

## pour créer une migration 

`bin/console doctrine:migration:generate`

## pour appliquer la dernière migration
`bin/console doctrine:migration:migrate`

## pour environnement dev : 
`bin/console doctrine:schema:update --force`

## Service UploadHelper 
C'est un service pour faciliter l'upload des fichiers (photo auteur, ouverage et autres) 
Le service est réutilisable par une simple injection de dépendance comme l'exemple ci-dessous
```
public function new(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
{
$auteur = new Auteur();
$form = $this->createForm(AuteurType::class, $auteur);
$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['photoFile']->getData();
            if ($uploadedFile) {
                $newFileName = $uploaderHelper->uploadFile($uploadedFile);
                $auteur->setPhotoAuteur($newFileName);
            }
            $entityManager->persist($auteur);
            $entityManager->flush();
```


## integration template back 
ajouter {% extends 'baseBack.html.twig' %}
et pour naviguer ajouter au fichier baseBack.html.twig 
  <li class="nav-item nav-category">************************* Le nom de l'entitée*************************</li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                        <i class="menu-icon mdi mdi-floor-plan"></i>
                        <span class="menu-title">************************* Le nom de l'entitée*************************</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse" id="ui-basic">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{ path('app_offre_index') }}">**********Exemple (Afficher Nom entitée)****** </a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ path('app_offre_index') }}">**********Exemple (Modifier Nom entitée)******</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{ path('app_offre_index') }}">**********Exemple (Supprimer Nom entitée)******</a></li>
                        </ul>
                    </div>
                </li>
