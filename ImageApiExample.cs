using System;
using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.Networking;

namespace AppApiExample
{
    // =========================================================================
    // 1. API 응답 매핑용 데이터 모델 (DTO)
    // Newtonsoft.Json 또는 Unity의 JsonUtility 모두 사용 가능하도록 필드 선언
    // =========================================================================

    [Serializable]
    public class PcbImage
    {
        public int id;
        public int pcb_idx;
        public string pcb_number;
        public string pcb_name_type;
        public string filename;
        public string image_url;
        public string bound_box;
        public string other;
        public string created_at;
    }

    [Serializable]
    public class DocImage
    {
        public int id;
        public int type;
        public string type_name;
        public string name;
        public string filename;
        public string image_url;
        public int? language;
        public string language_name;
        public string reference;
    }

    // Unity 내장 JsonUtility는 루트가 배열인 JSON(예: "[...]")을 직접 파싱하지 못하므로
    // 배열 파싱을 도와주는 헬퍼 래퍼 클래스를 정의합니다.
    public static class JsonHelper
    {
        public static List<T> FromJsonArray<T>(string json)
        {
            string newJson = "{ \"items\": " + json + " }";
            Wrapper<T> wrapper = JsonUtility.FromJson<Wrapper<T>>(newJson);
            return wrapper.items;
        }

        [Serializable]
        private class Wrapper<T>
        {
            public List<T> items;
        }
    }

    // =========================================================================
    // 2. 유니티용 API 호출 및 이미지 로더 컴포넌트 (MonoBehaviour)
    // =========================================================================

    public class ImageApiExample : MonoBehaviour
    {
        private const string BaseUrl = "http://cotaxdt.cafe24.com";

        // 테스트용: 인스펙터 창에서 드래그하여 확인할 렌더러 (예: RawImage 또는 MeshRenderer)
        [Header("UI Reference")]
        public UnityEngine.UI.RawImage displayRawImage;

        void Start()
        {
            // API 호출 테스트 시작
            StartCoroutine(FetchAndDisplayPcbImagesFlow());
        }

        /// <summary>
        /// PCB 이미지 목록을 가져온 후 첫 번째 이미지를 다운로드하여 화면에 띄우는 전체 흐름 코루틴
        /// </summary>
        private IEnumerator FetchAndDisplayPcbImagesFlow()
        {
            // ① PCB 이미지 목록 조회
            Debug.Log("PCB 이미지 목록 조회 요청 중...");
            yield return StartCoroutine(GetPcbImages(pcbList =>
            {
                if (pcbList != null && pcbList.Count > 0)
                {
                    Debug.Log($"PCB 목록 조회 성공. 항목 개수: {pcbList.Count}");
                    
                    foreach (var item in pcbList)
                    {
                        Debug.Log($"PCB 번호: {item.pcb_number}, 이미지 URL: {item.image_url}");
                    }

                    // ② 목록의 첫 번째 이미지를 로드하여 RawImage에 렌더링
                    string firstImageUrl = pcbList[0].image_url;
                    StartCoroutine(DownloadTexture(firstImageUrl, texture =>
                    {
                        if (texture != null && displayRawImage != null)
                        {
                            displayRawImage.texture = texture;
                            Debug.Log("RawImage에 첫 번째 이미지를 성공적으로 표시했습니다.");
                        }
                    }));
                }
                else
                {
                    Debug.LogWarning("조회된 PCB 이미지가 없거나 API 통신 실패.");
                }
            }));

            // ③ 문서 이미지 목록 조회 예시
            Debug.Log("문서 이미지 목록 조회 요청 중...");
            yield return StartCoroutine(GetDocImages(docList =>
            {
                if (docList != null && docList.Count > 0)
                {
                    Debug.Log($"문서 이미지 목록 조회 성공. 항목 개수: {docList.Count}");
                    foreach (var item in docList)
                    {
                        Debug.Log($"문서 명칭: {item.name}, 구분: {item.type_name}, URL: {item.image_url}");
                    }
                }
            }));
        }

        // =========================================================================
        // 3. UnityWebRequest 기반 통신 메서드들
        // =========================================================================

        /// <summary>
        /// PCB 이미지 목록 조회 (GET /api/pcb-images)
        /// </summary>
        public IEnumerator GetPcbImages(Action<List<PcbImage>> callback)
        {
            string url = $"{BaseUrl}/api/pcb-images";
            using (UnityWebRequest webRequest = UnityWebRequest.Get(url))
            {
                yield return webRequest.SendWebRequest();

                if (webRequest.result == UnityWebRequest.Result.Success)
                {
                    string jsonResult = webRequest.downloadHandler.text;
                    try
                    {
                        // JSON 배열 파싱
                        List<PcbImage> list = JsonHelper.FromJsonArray<PcbImage>(jsonResult);
                        callback?.Invoke(list);
                    }
                    catch (Exception ex)
                    {
                        Debug.LogError($"PCB JSON 파싱 에러: {ex.Message}");
                        callback?.Invoke(null);
                    }
                }
                else
                {
                    Debug.LogError($"PCB API 에러: {webRequest.error}");
                    callback?.Invoke(null);
                }
            }
        }

        /// <summary>
        /// 문서 이미지 목록 조회 (GET /api/doc-images)
        /// </summary>
        public IEnumerator GetDocImages(Action<List<DocImage>> callback)
        {
            string url = $"{BaseUrl}/api/doc-images";
            using (UnityWebRequest webRequest = UnityWebRequest.Get(url))
            {
                yield return webRequest.SendWebRequest();

                if (webRequest.result == UnityWebRequest.Result.Success)
                {
                    string jsonResult = webRequest.downloadHandler.text;
                    try
                    {
                        // JSON 배열 파싱
                        List<DocImage> list = JsonHelper.FromJsonArray<DocImage>(jsonResult);
                        callback?.Invoke(list);
                    }
                    catch (Exception ex)
                    {
                        Debug.LogError($"문서 JSON 파싱 에러: {ex.Message}");
                        callback?.Invoke(null);
                    }
                }
                else
                {
                    Debug.LogError($"문서 API 에러: {webRequest.error}");
                    callback?.Invoke(null);
                }
            }
        }

        /// <summary>
        /// 이미지 실물 파일을 Texture2D로 다운로드하여 불러오기 (GET /api/image/{type}/{filename})
        /// </summary>
        public IEnumerator DownloadTexture(string imageUrl, Action<Texture2D> callback)
        {
            using (UnityWebRequest webRequest = UnityWebRequestTexture.GetTexture(imageUrl))
            {
                yield return webRequest.SendWebRequest();

                if (webRequest.result == UnityWebRequest.Result.Success)
                {
                    // Texture2D 객체 추출
                    Texture2D texture = DownloadHandlerTexture.GetContent(webRequest);
                    callback?.Invoke(texture);
                }
                else
                {
                    Debug.LogError($"이미지 다운로드 에러: {webRequest.error} | URL: {imageUrl}");
                    callback?.Invoke(null);
                }
            }
        }
    }
}
