# Release and Versioning Guide

This guide describes the process for releasing a new official version of the **Alxarafe** framework and making it available on Packagist.

## 1. Semantic Versioning

The project follows the [Semantic Versioning 2.0.0](https://semver.org/) standard.
The version format is **MAJOR.MINOR.PATCH** (e.g. `1.0.2`).

*   **MAJOR (1.x.x):** Incompatible API changes (Breaking Changes).
*   **MINOR (x.1.x):** New functionality in a backward compatible manner.
*   **PATCH (x.x.1):** Backward compatible bug fixes.

## 2. Publication Process

Once the code on the `main` branch is ready, tested, and committed, follow these steps to release:

### Step 1: Create the Tag

Git uses tags to mark specific points in history as versions.

```bash
# Create the tag locally (e.g. v1.0.1)
git tag v1.0.1 -m "Brief description (e.g. Router bug fix)"
```

### Step 2: Push the Tag to GitHub

Tags are not pushed with a standard `git push`. You must push them explicitly:

```bash
# Push a specific tag
git push origin v1.0.1

# Or push all local tags
git push origin --tags
```

## 3. Packagist Update

### Automatic (Recommended)
If you have configured the **GitHub Webhook** in your Packagist account, Packagist will automatically detect the new tag as soon as you `push` and publish the version within minutes.

### Manual
If you don't have the webhook configured or need to force an update immediately:

1.  Log in to [Packagist.org](https://packagist.org/).
2.  Go to your package page: [alxarafe/alxarafe](https://packagist.org/packages/alxarafe/alxarafe).
3.  Click the green **"Update"** button on the right.
4.  Packagist will scan GitHub and find the new `v1.0.1` version.

## 4. Verify

To confirm the version is available, run inside any project:

```bash
composer show alxarafe/alxarafe --all
```

You should see the new version listed.
