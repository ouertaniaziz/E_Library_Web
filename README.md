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
